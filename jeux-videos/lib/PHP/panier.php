<?php
include_once 'connexionBD.php';


/* 
 * Fonction permettant d'afficher le montant total de la commande 
*/
function afficherMontant($montantTotal)
{
	if ($montantTotal > 0)
	{
		/* Définition du style ici car il n'y a pas besoin d'une classe spécifique */
		echo '<div style="text-align: right">TOTAL = '.$montantTotal.' € </div>';  

		echo '<br/>';

		/* On affiche le bouton "VIDER LE PANIER" */
		echo '<div class="bouton-container2">';
			echo '<form method="post">';
				echo '<button type="submit" name="vider" class="bouton"> <font> VIDER LE PANIER </font> </button>';
			echo '</form>';
		echo '</div>';

		echo '<br/>';
	}
} 


/* 
 * Fonction permettant de supprimer le panier 
*/
function supprimerPanier()
{
	try 
	{
		/* Suppression de tous les articles commandés de la table */
		connexionMariaDB("DELETE FROM panier_article WHERE id_panier = 1");  
	} 
	catch (PDOException $e)  
	{
		/* Gérer les exceptions en cas d'erreur lors de l'exécution de la requête SQL */
		echo "Erreur lors de la suppression des articles de la base de données : " . $e->getMessage();
		exit();
	}
}


/* 
 * Fonction permettant d'afficher le panier 
*/
function afficherPanier() 
{
	try
	{
		/* On vérifie si un formulaire a été soumis */
		if ($_SERVER ['REQUEST_METHOD'] === 'POST')
		{
			/* Si c'est le bouton "VIDER LE PANIER", on supprime le panier */
			if(isset($_POST['vider'])) 
			{
				supprimerPanier();
			}
		}
	
		$panierArticle = connexionMariaDB("SELECT panier.id_article, panier.quantite, panier.prix_ttc, article.libelle
											FROM panier_article panier
											JOIN article ON panier.id_article = article.id")->fetch_all(MYSQLI_ASSOC); // Transformation en tableau accessible
		
		$montantTotal = 0;
		
		echo '<table>';
				echo '<tr>';
					echo '<th>';
						echo '<div class="Caddie-container">';
							echo '<img src="img_site/caddie.gif" alt="Logo du panier"> <font> votre panier </font>';
						echo '</div>';
					echo '</th>';
				echo '</tr>';
		
				echo '<tr class="ligne2">';
					echo '<th>';

						foreach ($panierArticle as $article) 
						{
							$prixTotalAticle = number_format($article['quantite'] * $article['prix_ttc'], 2);   // 2 -> 2 chiffres après la virgule

							$montantTotal += $prixTotalAticle;
							
							/* Définition du style ici car il n'y a pas besoin d'une classe spécifique */
							echo '<div style="text-align: left">';
								echo $article['libelle'];
							echo '</div>';
							
							/* Définition du style ici car il n'y a pas besoin d'une classe spécifique */
							echo '<div style="text-align: right">';
								echo $article['quantite']. ' x ' .$article['prix_ttc']. ' = ' .$prixTotalAticle. ' €';
							echo '</div>';
						}

					echo '</th>';
				echo '</tr>';
				
				/* Style permettant d'afficher la bordure supérieur de la troisième ligne du tableau si un montant global est à afficher */
				echo '<tr class="ligne3' .(ContenuPresent() ? ' contenu-present' : ''). '">';
					echo '<th>';
						afficherMontant($montantTotal);	
					echo '</th>';
				echo '</tr>';
		echo '</table>';
	}
	catch (PDOException $e)  
	{
		/* Gérer les exceptions en cas d'erreur lors de l'exécution de la requête SQL */
		echo "Erreur dans la fonction afficherPanier : " . $e->getMessage();
		exit();
	}
	
}


/* 
 * Fonction permettant de savoir si l'utilisateur a commandé des articles (permet de savoir s'il faut mettre la bordure de la 3ème ligne du panier)
*/
function contenuPresent() 
{
	try
	{
		$panierArticle = connexionMariaDB("SELECT quantite FROM panier_article")->fetch_assoc();

		/* Vérification de la présence d'articles dans la table panier_article */
		if ($panierArticle)
		{
        	return true; // Retourne true s'il y a des articles dans le panier
    	}

    	return false;    // Retourne false s'il n'y a pas d'article dans le panier
	}
	catch (PDOException $e)  
	{
		/* Gérer les exceptions en cas d'erreur lors de l'exécution de la requête SQL */
		echo "Erreur dans la fonction contenuPresent : " . $e->getMessage();
		exit();
	} 
}

?>