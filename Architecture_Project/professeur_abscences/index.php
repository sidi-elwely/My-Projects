<?php
	session_start();
	include('../etudiant/fonctions.php');
?>
<html>
	<head>
		<link rel="stylesheet" href="style.css">
	</head>
	<header class="header">
		<div class="logo">
			<img src="../images/logo.jpg">
		</div>
		<div class="profil">
			<img src="../images/photo.png">
			<?php
				$db = db_connect(); /* se déconnecter de la base */
				$email = $_SESSION['email'];
				$sql = "SELECT * FROM professeur WHERE mailProf = '$email'";
				$result = db_query($db, $sql);
				$data = mysqli_fetch_array($result);
				$name=$data['nomProf'].' '.$data['prenomProf'];
				echo "<figcaption> $name </figcaption>";
			?>
		</div>
	</header>
	<body>
	    
		<section class="container">
			<form class="left-half" method="post" >
				<article>
					<table class="t2">
						<h3>Liste des éleves</h3>
						<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>date absence</th>
						</tr>
						<?php
							$nomCours = $data['nomCours'];
							$sql1 = "SELECT * FROM etudiant INNER JOIN absence ON etudiant.idEtu = absence.idEtu
							where absence.nomCours='$nomCours'";
							$result1 = db_query($db, $sql1);
							if(!empty($_POST)){
								
								if ($_POST['send']=='soumission') {
									
									$sql1 = "SELECT * FROM absence WHERE nomCours = '$nomCours'";
									$result1 = db_query($db, $sql1);
									if(isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['prenom'] )&& isset($_POST['abs']))
									{
										
										$id = $_POST['id'];
										$nom= $_POST['nom'];
										$date = $_POST['abs'];
										$sql3 = "INSERT INTO absence VALUES ($id, '$nomCours', STR_TO_DATE('$date','%d/%m/%Y'))";
										$result3 = db_query($db, $sql3);
									}
									
									$sql1 = "SELECT * FROM etudiant INNER JOIN absence ON etudiant.idEtu = absence.idEtu
									where absence.nomCours='$nomCours'";
									$result1 = db_query($db, $sql1);
									while($data1 = mysqli_fetch_array($result1)){
									
										echo '<tr >
											<th class = "t1">'.$data1['idEtu'].'</th>
											<th class = "t1">'.$data1['nomEtu'].'</th>
											
											<th class = "t1">'.$data1['prenomEtu'].'</th>
											<th class = "t1">'.$data1['heurs'].'<input id="prodId" name="send" type="hidden" value="update'.$data1['idEtu'].'"></th>
		
										</tr>';
										
									}
									
									
								}     
								if($_POST['send']=='ajout') {
									echo '<tr >
										<th class = "t1"><input type="text" id="note" name="id" ></th>
										<th class = "t1"><input type="text" id="note" name="nom" ></th>
										<th class = "t1"><input type="text" id="note" name="prenom" ></th>
										<th class = "t1"><input type="text" id="note" name="abs" > </th>
										
									  </tr>'; 
									
									
								} 
								
							}
							else{
								$sql1 = "SELECT * FROM etudiant INNER JOIN absence ON etudiant.idEtu = absence.idEtu
								where absence.nomCours='$nomCours'";
								$result1 = db_query($db, $sql1);
								while($data1 = mysqli_fetch_array($result1)){
									echo '<tr >
									    <th class = "t1">'.$data1['idEtu'].'</th>
										<th class = "t1">'.$data1['nomEtu'].'</th>
										<th class = "t1">'.$data1['prenomEtu'].'</th>
										
										<th class = "t1">'.$data1['heurs'].'</th>
									  </tr>';
								}
							}
							


						?>
					</table>
					<button type="submit" name="send" value="soumission">Soumettre</button>
				    <button type="submit" name="send" value="ajout">Ajouter</button>
				</article>
			</form>	
			<div class="right-half">
				<article>
					<ul class="menu">
						<li>
							<a href="../professeur_rating/index.php"><div class="absences">modifier les notes</div></a>
						</li>
						<li>
							<a href="../analyse_dashboard/index.php"><div class="absences">consulter le dashboard</div></a>
						</li>
						<li>
							<a href="../acceuil_premierpage/index.php"><div class="absences">Déconnexion</div></a>
						</li>
					</ul>
				</article>
			</div>
		</section>
	</body>
</html>