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
				$db = db_connect(); /* se connecter de la base */
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
							<th>Professeur</th>
							<th> Date </th>
						</tr>
						<?php 
							$db = db_connect(); /* se déconnecter de la base */
							$email = $_SESSION['email'];
							$sql = "SELECT * FROM etudiant where mailEtu = '$email'";
							$result = db_query($db, $sql);
							$data = mysqli_fetch_array($result);
							$name=$data['nomEtu'].' '.$data['prenomEtu'];
							$sql = "SELECT * FROM absence INNER JOIN professeur 
								on absence.nomCours = professeur.nomCours WHERE absence.idEtu = ".$data['idEtu'];
							$result = db_query($db, $sql);
							while($data = mysqli_fetch_array($result)){
								echo '<tr >
										<th class = "t1">'.$data['nomCours'].'</th>
										<th class = "t1">'.$data['nomProf'].' '.$data['prenomProf'].'</th>
										<th class = "t1">'.$data['heurs'].'</th>
										
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
							<a href="../etudiant_rating/index.php"><div class="absences">Consulter mes notes</div></a>
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