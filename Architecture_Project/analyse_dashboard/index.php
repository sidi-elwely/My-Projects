<?php
	session_start();
	include('../etudiant/fonctions.php');
	$db = db_connect(); /* se déconnecter de la base */
	$email = $_SESSION['email'];
	$sql = "SELECT * FROM professeur WHERE mailProf='$email'";
	$result = db_query($db, $sql);
	$data = mysqli_fetch_array($result);
	$nomCours=$data['nomCours'];
	$sql = "SELECT count(idEtu) FROM notes INNER JOIN professeur ON notes.nomCours = professeur.nomCours WHERE mailProf = '$email' and notes.note >= 10 ";
	$result = db_query($db, $sql);
	
	$sql2 = "SELECT count(idEtu) FROM notes WHERE nomCours='$nomCours' and notes.note < 10 ";
	$result2 = db_query($db, $sql2);
	$sql3 = "SELECT count(idEtu) FROM absence WHERE nomCours='$nomCours'";
	$result3 = db_query($db, $sql3);
	
	$sql4 = "SELECT count(idEtu) FROM etudiant";
	$result4 = db_query($db, $sql4);
?>

<html lang="en">
<head>
	<title>Bienvenue chez Etu_Prof!</title>
	 <link href="style.css" rel="stylesheet" media="all" type="text/css">
	 <meta charset="UTF-8">
	 <meta name="viewport"
				content="width=device-width",user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
	 <meta http-equiv="X-UA-Compatible" content="ie=edge">
	 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
     <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data1 = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
		  <?php
			$data = mysqli_fetch_array($result);
			$data2 = mysqli_fetch_array($result2);
			echo "['sup à 10',".$data[0]."],['inf à 10',".$data2[0]."]";
		  ?>
        
		 ]);
		 
		 var data2 = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
		  <?php
			$data3 = mysqli_fetch_array($result3);
			$data4 = mysqli_fetch_array($result4);
			echo "['absent',".$data3[0]."],['present',".($data4[0] - $data3[0])."]";
		  ?>
        
		 ]);

        var options1 = {
          title: 'pourcentage des eleves par apport à la moyenne'
        };
		var options2 = {
          title: 'pourcentage des des absencces'
        };

        var chart1 = new google.visualization.PieChart(document.getElementById('piechart1'));
		var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart1.draw(data1, options1);
		chart2.draw(data2, options2);
      }
	  
    </script>
	 
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
				$sql = "SELECT * FROM professeur where mailProf = '$email'";
				$result = db_query($db, $sql);
				$data = mysqli_fetch_array($result);
				$name=$data['nomProf'].' '.$data['prenomProf'];
				echo "<figcaption> $name </figcaption>";
			?>
		</div>
	</header>
	<body>
	<div class="container">
	<?php 
			$db = db_connect(); /* se déconnecter de la base */
			$email = $_SESSION['email'];
			$sql1 = "SELECT nomCours FROM professeur where mailProf = '$email'";
			$result1 = db_query($db, $sql1);
			$data1 = mysqli_fetch_array($result1);
			$nomCours = mysqli_real_escape_string($db, $data1['nomCours']);
			$sql = "SELECT count(idEtu) FROM etudiant";
			$result = db_query($db, $sql);
			$data = mysqli_fetch_array($result);
            echo '	
			<div class="blocs">
		    <div class="bloc">
			<div class="text">Nombre des étudiants : <br>'.$data[0].'</div>
			<br>
		   </div>';
	        $sql ="SELECT avg(note) FROM notes WHERE nomcours ='$nomCours'"; 
			$result = db_query($db, $sql);
			$data = mysqli_fetch_array($result);
			echo '
			<div class="bloc">
			<div class="text"> Moyenne de la classe : <br>'.$data[0].' </div>
			<br>
			</div>';
			$sql ="SELECT max(note) FROM notes WHERE nomcours = '$nomCours'"; 
			$result = db_query($db, $sql);
			$data = mysqli_fetch_array($result);
			echo '
			<div class="bloc">
			<div class="text">	Première note : <br>'.$data[0].' </div>
			<br>
			</div>';
		    $sql ="SELECT min(note) FROM notes WHERE nomcours = '$nomCours'"; 
			$result = db_query($db, $sql);
			$data = mysqli_fetch_array($result);
			echo '
			<div class="bloc">
				<div class="text">	Dernière note : <br>'.$data[0].' </div>
			</div>
			</div>';	
			  
	?>
		<div id="piechart1"></div> 
		<div id="piechart2"></div>
	</div>
	<div class="right-half">
				<article>
					<ul class="menu">
						<li>
							<a href="../professeur_abscences/index.php"><div class="absences">modifier les absences</div></a>
						</li>
						<li>
							<a href="../professeur_rating/index.php"><div class="absences">modifier les notes</div></a>
						</li>
						<li>
							<a href="../acceuil_premierpage/index.php"><div class="absences">Déconnexion</div></a>
						</li>
					</ul>
				</article>
			</div>
	</body>
</html>