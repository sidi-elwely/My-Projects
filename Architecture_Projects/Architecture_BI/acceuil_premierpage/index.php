<?php
    session_start();
	session_destroy ();
?>

<html>
    <head>
        <title> Bienvenue chez EtuProf ! </title>
        <link href="style_prof.css" rel="stylesheet" media="all" type="text/css"> 
    </head>
   <body>
        <div>
			<h2>Bienvenu au portail EtuProf</h2>
			<h3>Qui êtes vous ?</h3>
			<div>
				<ul class="menu">
					<li>
						<a href="../etudiant_login/index.php"><div class="position">Etudiant</div></a>
					</li>
					<li>
						<a href="../professeur_login/index.php"><div class="position">Professeur</div></a>
					</li>
				</ul>
			</div>
		</div>
   </body>
</html>