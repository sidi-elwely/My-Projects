
<?php
include_once 'connexionBD.php';


/* 
 * Fonction permettant d'afficher les articles d'une famille 
*/
function afficherArticles($requete)
{
	try
	{
		$resultat = connexionMariaDB($requete);

		/* Vérification de la présence d'éléments dans résultat */
		if(mysqli_num_rows($resultat) > 0) 
		{
			$i = 0;

			/* Affichage des articles */
			while($article = mysqli_fetch_array($resultat)) // On transforme chaque ligne en contenu accessible
			{
				/* Affichage de l'article avec son image, son nom, sa description, son prix ttc et son bouton commander */
				echo '<div class="article">';
					echo ' <img src="img_articles/'.$article['image'].'" >';
					
					echo '<p>';
						echo '<span class="libelle">' .$article['libelle']. '</span>'; 
						echo '<br>';
						echo '<span class="detail">' .$article['detail']. '...</span>';
						echo '<br>';
						echo '<br>';	
						echo '<span class="prix">' .$article['prix_ttc']. ' €</span>';
						echo '<br>';
						echo '<br>';
					echo '</p>';
				
					echo '<form method="post">';
						/* On ajoute une marge directement ici car elle n'est utile que pour ce bouton */
						echo '<button type="submit" name="commander'.$i.'" class="bouton" style="margin-left: 24px;"> <font> COMMANDER </font> </button>';
					echo '</form>';
					
					/* On vérifie si un formulaire a été soumis */
					if ($_SERVER ['REQUEST_METHOD'] === 'POST')
					{
						/* L'appuie sur commander va ajouter l'article dans la base de données */
						if(isset($_POST['commander'.$i])) 
						{
							/* On récupère les données liées au bouton commanderi */
							$idArticle = $article['id'];
							$prixArticle = $article['prix_ttc'];
							ajouterArticle($prixArticle, $idArticle);
						}	
					}
					
				echo '</div>';
				$i++;
			}

			echo '</br>';

			/* Bouton retour en fin de page */
			echo '<div class="bouton-container"> 
				<a href="http://localhost/jeux-videos" class="bouton">  <font> Retour </font> </a>';
			echo '</div>';
		} 
		else 
		{
			echo "Aucun article trouvé pour cette famille.";
		}
	}
	catch (PDOException $e)  
	{
		/* Gérer les exceptions en cas d'erreur lors de l'exécution de la requête SQL */
		echo "Erreur dans la fonction afficherArticles : " . $e->getMessage();
		exit();
	}

}


/* 
 * Fonction permettant d'afficher les catégories des jeux
*/
function afficherCategories($requete)
{
	try 
	{
		$resultat = connexionMariaDB($requete);

		/* Liste des voyelles pour la définition du D' pour le nom des jeux (on ajoute le h car c'est un cas particulier) */
		$voyelles = array('a', 'e', 'i', 'o', 'u', 'y', 'h');

		/* Vérification de la présence d'éléments dans résultat */
		if(mysqli_num_rows($resultat) > 0)
		{

			while($article = mysqli_fetch_array($resultat)) 
			{
				echo '<div class="cercle-container">';
					/* Affichage des cercles cliquables */
					echo '<div class="cercle">';
						echo '<a href="index.php?famille=' .$article['id']. '"> <img src="./img_categories/' .$article['image']. '"> </a>';
					echo '</div>';

					$premiereLettre = substr($article['libelle'], 0, 1);
					
					/* Test pour savoir si la première lettre est une voyelle */
					if (in_array($premiereLettre, $voyelles))
					{
						echo '<font> JEUX </font>';
						echo "<font> D'" .strtoupper($article['libelle']). "</font>";
					}
					else
					{
						$longueur = strlen($article['libelle']);

						/* Si le mot est de longueur supérieur à 5, on doit afficher le nom du jeu sur deux lignes */
						if ($longueur > 5)
						{
							echo '<font> JEUX DE </font>'; 
							echo '<font>' .strtoupper($article['libelle']). '</font>';
						}
						else
						{
							echo '<font> JEUX DE ' .strtoupper($article['libelle']). '</font>'; 
						}
						
					}
				echo '</div>';
			}
		}
		else
		{
			echo "Aucune famille trouvée.";
		}
	}
	catch (PDOException $e)  
	{
		/* Gérer les exceptions en cas d'erreur lors de l'exécution de la requête SQL */
		echo "Erreur dans la fonction afficherArticles : " . $e->getMessage();
		exit();
	}
	
}


 /* 
  * Fonction permettant d'ajouter un article dans la table panier_article lorsqu'on clique sur commander 
*/
 function ajouterArticle($prixArticle, $idArticle) 
 {
	try
	{
		/* Requête pour vérifier si l'article existe déjà dans la table panier_article */
		$resultat = connexionMariaDB("SELECT quantite FROM panier_article WHERE id_panier = 1 AND id_article = $idArticle")->fetch_assoc();

		/* L'article est déjà présent */
		if ($resultat) 
		{
			/* Incrémentation de sa quantité */
			$quantite = $resultat['quantite'] + 1;

			/* Mise à jour de la base de donnée */
			connexionMariaDB("UPDATE panier_article SET quantite = $quantite WHERE id_panier = 1 AND id_article = $idArticle");
		} 

		/* L'article n'existe pas encore dans la table */
		else 
		{
			/* Requète pour récupérer la TVA s'appliquant sur l'article */
			$tvaArticle = connexionMariaDB("SELECT taux FROM article JOIN tva ON article.id_tva = tva.id WHERE article.id = $idArticle")->fetch_assoc();

			/* Calcule du montant de la TVA pour l'article */
			$prixTva= ($tvaArticle['taux'] / 100) * $prixArticle; 

			/* Calcule du prix hors taxe du produit */
			$prixHt = $prixArticle - $prixTva; 

			/* On insert le nouvel article */
			connexionMariaDB("INSERT INTO panier_article (id_panier, id_article, quantite, prix_ht, prix_tva, prix_ttc) 
							  VALUES (1,$idArticle, 1, $prixHt, $prixTva, $prixArticle)");
		}
	}
	catch (PDOException $e)  
	{
		/* Gérer les exceptions en cas d'erreur lors de l'exécution de la requête SQL */
		echo "Erreur dans la fonction afficherArticles : " . $e->getMessage();
		exit();
	}
}


/* 
 * Fonction permettant d'afficher le contenu (catégories ou articles) 
*/
function afficherContenu()
{
	if(isset($_GET['famille'])) 
	{
        /* Récupération de l'id de la famille depuis l'URL */
        $famille = $_GET['famille'];

        /* Exécution de la requête */
		afficherArticles("SELECT * FROM article WHERE id_categorie = $famille");
        
    } 
	else 
	{
        /* Affichage des catégories si le paramètre "famille" n'est pas présent dans l'URL */
		afficherCategories("SELECT libelle, id, image FROM categorie");
    }
}

?>


