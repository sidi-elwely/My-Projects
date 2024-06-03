<html>
	<head>
		<!-- titre de la fenêtre -->
		<title>Jeux-vidéos</title>

		<!-- précise l'encodage au navigateur (gestion des accents, ...) -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

		<!-- Feuilles de style -->
		<link rel="stylesheet" type="text/css" href="lib/CSS/article.css"/>
		<link rel="stylesheet" type="text/css" href="lib/CSS/bouton.css"/>
		<link rel="stylesheet" type="text/css" href="lib/CSS/redefinitions.css"/>
		<link rel="stylesheet" type="text/css" href="styles.css"/>
		
		<!-- Inhibe la grande largeur sur mobile : évite que le mobile présente un écran large et qu'il faille zoomer -->
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0" />

		<!-- icône de la page (celle de WAMP prend le dessus...)-->
		<link rel="icone" href="img_site/icone-site.gif"/>
	
	</head>
	
	<body>
		<div class="Page">
			
			<div class="Titre"> 
				<table>
					<tr>
						<!-- L'icône et le titre sont cliquables -->
						<th> <a href="http://localhost/jeux-videos"> <img src="img_site/icone-site.gif" alt="Logo du titre"> </a> </th>
						<th> <a href="http://localhost/jeux-videos"> <font> Jeux vidéos </font> </a> </th>
					</tr>
				</table>
			</div>
			
			<div class="Cadre-authentification">
				<table>
					<tr>
						<td> adresse mail </td>
					</tr>
					<tr>
					  	<td> <input type="text" name="adresse mail" size="27" style="height: 30px;"> </td>
					</tr>
					<tr>
					  	<td> mot de passe </td>
					</tr>
					<tr>
					  	<td> <input type="text" name="mot de passe" size="27" style="height: 30px;"> </td>
					</tr>
			    </table> 
				<div class="bouton-container">
					<div class="Bouton"> <font> S'INSCRIRE </font> </div>
					<div class="bouton">  <font> CONNEXION </font> </div>
				</div>
			</div>
				
			<div class="Contenu">
				<?php
					include('lib/PHP/contenu.php');
					afficherContenu();
				?>
			</div>
			
			<div class="Panier"> 
				<?php
					include('lib/PHP/panier.php');
					afficherPanier();
				?>
			</div>
			
			<div class="Pieds_de_page">

			</div>
		</div>
	</body>
</html>