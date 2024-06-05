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
							<th>Nom</th>
							<th>Prénom</th>
							<th>Note</th>
							<th> Remarques </th>
						</tr>
						<?php
							$nomCours = $data['nomCours'];
							$sql1 = "SELECT * FROM etudiant INNER JOIN notes ON etudiant.idEtu = notes.idEtu
							where notes.nomCours='$nomCours'";
							$result1 = db_query($db, $sql1);
							if(!empty($_POST)){
								
								if ($_POST['send']=='soumission') {
									
									$sql1 = "SELECT * FROM notes WHERE nomCours = '$nomCours'";
									$result1 = db_query($db, $sql1);
									while($data1 = mysqli_fetch_array($result1)){
										if(!empty($_POST['note'.$data1['idEtu']]) ){
											
											$remarque =$_POST['remarque'.$data1['idEtu']];
											$note =$_POST['note'.$data1['idEtu']];
											$sql2 = "UPDATE notes SET note = ".$_POST['note'.$data1['idEtu']]." WHERE idEtu = ".$data1['idEtu']." AND nomCours='$nomCours'";
											$result12= db_query($db, $sql2);
											$sql3 = "UPDATE notes SET remarque = '".$_POST['remarque'.$data1['idEtu']]."' WHERE idEtu = ".$data1['idEtu']." AND nomCours='$nomCours'";
										    $result13= db_query($db, $sql3);
										}
									}
									
									$sql1 = "SELECT * FROM etudiant INNER JOIN notes ON etudiant.idEtu = notes.idEtu
									where notes.nomCours='$nomCours'";
									$result1 = db_query($db, $sql1);
									while($data1 = mysqli_fetch_array($result1)){
									
										echo '<tr >
											<th class = "t1">'.$data1['nomEtu'].'</th>
											
											<th class = "t1">'.$data1['prenomEtu'].'</th>
											<th class = "t1">'.$data1['note'].'<input id="prodId" name="send" type="hidden" value="update'.$data1['idEtu'].'"></th>
											<th class = "t1">'.$data1['remarque'].'<input id="prodId" name="send" type="hidden" value="update'.$data1['idEtu'].'"></th>
											<th class = "t1"></th>
										</tr>';
										
									}
									
									
								}     
								if($_POST['send']=='modification') {
									while($data1 = mysqli_fetch_array($result1)){
									echo '<tr >
										<th class = "t1">'.$data1['nomEtu'].'</th>
										<th class = "t1">'.$data1['prenomEtu'].'</th>
										<th class = "t1"><input type="text" id="note" name="note'.$data1['idEtu'].'" > </th>
										<th class = "t1"><input type="text" id="remarque" name="remarque'.$data1['idEtu'].'" </th>
									  </tr>'; 
									}
									
									
								} 
								//$_POST = array();
								
							}
							else{
								$sql1 = "SELECT * FROM etudiant INNER JOIN notes ON etudiant.idEtu = notes.idEtu
								where notes.nomCours='$nomCours'";
								$result1 = db_query($db, $sql1);
								while($data1 = mysqli_fetch_array($result1)){
									echo '<tr >
										<th class = "t1">'.$data1['nomEtu'].'</th>
										<th class = "t1">'.$data1['prenomEtu'].'</th>
										
										<th class = "t1">'.$data1['note'].'</th>
										<th class = "t1">'.$data1['remarque'].'</th>
										<th class = "t1"></th>
									  </tr>';
								}
							}
							


						?>
					</table>
					<button type="submit" name="send" value="soumission">Soumettre</button>
				    <button type="submit" name="send" value="modification">Modifier </button>
				</article>
			</form>	
			<div class="right-half">
				<article>
					<ul class="menu">
						<li>
							<a href="../professeur_abscences/index.php"><div class="absences">modifier les absences</div></a>
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