<?php
//session_start();
/*
if(isset($Actualité) AND $rang == 2){		//On met au préalable dans la variable rang le rang de l'user
	//On met le menu déroulant en remplaçant l'icone connection avec (paramètre, modification, déconnexion)
	//On met ici les liens vers la page de modification des paramètres du tuple dans la BDD
}*/
 ?>
<!DOCTYPE>
<html>
	<head>
		<!-- On défini le type d'encodage -->
		<meta charset="utf-8" />
		<link rel="icon" type="image/png" href="Icones/Rugby_union_pictogram.png" />
    <link rel="stylesheet" href="Connexion.css" />
		<title>Paris 2024: Rugby Subaquatique</title>
	</head>

  <body>
    <div class="Connexion">
        <p>
          <?php if(isset($_SESSION['Identifiant'])) { echo $_SESSION['Identifiant'] ; } ?>
        </p>
        <?php
        if (!isset($_SESSION['Identifiant'])){
              echo '<a href="login.php"><img src="Icones/icons8-dégradé-linéaire-64.png" class="IconConnexion" alt="Iconconnexion"></a>';
        }
        elseif (isset($_SESSION['Identifiant'])){
          echo '<div class="Parametre"><img src="Icones/Parametre.png" class="IconConnexion" alt="Iconconnexion">
          <div class="Parametre_Deroulant">
            <a href="Paramètre.php">Paramètre</a>
            <a href="Calendrier.php">Calendrier</a>
			<a href="ListeUtilisateurs.php">Liste des utilsateurs</a>
            <a href="Déconnexion.php">Déconnexion</a>
          </div>
          </div>';
        }
        ?>
    </div>
  </body>
</html>
