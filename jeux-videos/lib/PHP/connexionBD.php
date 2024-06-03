<?php

/* 
 * Fonction prenant en argument une requête et interrogeant la base de données afin d'obtenir un résultat 
*/
function connexionMariaDB($requete)
{
    /* On se connecte à MariaDB */
	$connexion = mysqli_connect('localhost', 'jeux-videos',  'IsImA_2023/%', 'jeux-videos', 3307) 
												or die('Erreur SQL : '. mysqli_error($db));

	$connexion -> query ('SET NAMES UTF8');

	/* On exécute la requête */
	$resultat = $connexion -> query($requete) or die('Erreur SQL : '.mysqli_error($connexion));
	
	/* On ferme la connexion à MariaDB */
	mysqli_close($connexion);
	
	/* On retourne le résultat de la requête */
	return $resultat;
}

?>