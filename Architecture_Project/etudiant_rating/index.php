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
				$sql = "SELECT * FROM etudiant where mailEtu = '$email'";
				$result = db_query($db, $sql);
				$data = mysqli_fetch_array($result);
				$name=$data['nomEtu'].' '.$data['prenomEtu'];
				echo "<figcaption> $name </figcaption>";
			?>
		</div>
	</header>
	<body>
	    
		<section class="container">
			<div class="left-half">
				<article>
					<table class="t2">
						<tr>
							<th>Matiére</th>
							<th>Note</th>
							<th>Professeur</th>
							<th> Remarques </th>
						</tr>
						<?php 
							$db = db_connect(); /* se déconnecter de la base */
							$email = $_SESSION['email'];
							$sql = "SELECT * FROM etudiant where mailEtu = '$email'";
							$result = db_query($db, $sql);
							$data = mysqli_fetch_array($result);
							$name=$data['nomEtu'].' '.$data['prenomEtu'];
							$sql = "SELECT * FROM notes INNER JOIN professeur 
								on notes.nomCours = professeur.nomCours WHERE notes.idEtu = ".$data['idEtu'];
							$result = db_query($db, $sql);
							while($data = mysqli_fetch_array($result)){
								echo '<tr >
										<th class = "t1">'.$data['nomCours'].'</th>
										<th class = "t1">'.$data['note'].'</th>
										<th class = "t1">'.$data['nomProf'].' '.$data['prenomProf'].'</th>
										<th class = "t1">'.$data['remarque'].'</th>
										<th class = "t1"></th>
									  </tr>';
							}
							
						?>
						
					</table>
				</article>
			</div>
			<div class="right-half">
				<article>
					<ul class="menu">
						<li>
							<a href="../etudiant_abscences/index.php"><div class="absences">Consulter mes absences</div></a>
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