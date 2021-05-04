<?php
session_start();

try
{
/* $bdd = new PDO('mysql:host=localhost;dbname=rugbysubaquatique', 'web', 'Jesuis1mdp'); */
$bdd = new PDO('mysql:host=localhost;dbname=rugbysubaquatique;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
$reponse = NULL;

// On vient récupérer le rang de l'utilisateur en utilisant ses données qui sont en session car il s'est connecté
$reqRang = $bdd->prepare('SELECT Rang FROM users WHERE Identifiant = :Id AND Mot_de_passe = :mdp');
$reqRang -> execute(array('Id'=> $_SESSION['Identifiant'], 'mdp'=> $_SESSION['mdp']));
$Rang = $reqRang -> fetch();

// On vient récupérer l'Id de l'utisateur
$reqId = $bdd->prepare('SELECT Id FROM users WHERE Identifiant = :Identifiant AND Mot_de_passe = :mdp');
$reqId->execute(array('Identifiant' => $_SESSION['Identifiant'] , 'mdp' => $_SESSION['mdp']));
$Id = $reqId -> fetch();

// On fait les tests pour savoir si les champs sont vides pour qu'ils puissent modifier les informations de sont propres profils
if(isset($_POST['Identifiant_Modifier'] , $_POST['Email_Modifier'] , $_POST['mdp_Modifier'] , $_POST['Confirm_mdp'])){
    if(!empty($_POST['Identifiant_Modifier']) AND !empty($_POST['Email_Modifier']) AND !empty($_POST['mdp_Modifier']) AND !empty($_POST['Confirm_mdp'])){
      if($_POST['mdp_Modifier'] == $_POST['Confirm_mdp']){

/*
    $reqId = $bdd->prepare('SELECT Id FROM users WHERE Identifiant = :Identifiant AND Mot_de_passe = :mdp');
    $reqId -> execute(array('Identifiant'=> $_POST['Identifiant'], 'mdp'=>$_POST['mdp']));

    $UPDATE = $bdd->prepare('UPDATE users SET Identifiant = :Identifiant , Email = :Email, Mot_de_passe = :mdp WHERE Id = :Id');
    $UPDATE->execute(array('Identifiant'=> $_POST['Identifiant_Modifier'], 'Email' => $_POST['Email_Modifier'] , 'mdp'=>$_POST['mdp_Modifier'] , 'Id' => $reqId));
*/

        $UPDATE = $bdd->prepare('UPDATE users SET Identifiant = :Identifiant_Modifier , Email = :Email, Mot_de_passe = :mdp_Modifier WHERE Id = :Id');
        $UPDATE->execute(array('Identifiant_Modifier'=> $_POST['Identifiant_Modifier'], 'Email' => $_POST['Email_Modifier'] , 'mdp_Modifier'=>$_POST['mdp_Modifier'] , 'Id' => $Id['Id']));
        $_SESSION['Identifiant'] = $_POST['Identifiant_Modifier'];
        $_SESSION['mdp'] = $_POST['mdp_Modifier'];
        $reponse = 'Modification effectuée';

      }
      else {
        $reponse = 'Le Mot de passe est différent sur les deux champs';
      }
    }
    else {
      $reponse = 'Veuillez remplir tous les champs';
    }
}


// On fait les tests et la requête pour modifier le rang de n'importe quel utilisateur (seulement pour les admin)
if ($Rang['Rang'] === 'Administrateur') {
  if (isset($_POST['Identifiant_Modifier_AC'] , $_POST['Rang_Modifier_AC'])) {
    if (!empty($_POST['Identifiant_Modifier_AC']) AND !empty($_POST['Rang_Modifier_AC'])) {
      $UPDATERang = $bdd->prepare('UPDATE users SET Rang = :Rang WHERE Identifiant = :Identifiant');
      $UPDATERang->execute(array('Rang'=>$_POST['Rang_Modifier_AC'] , 'Identifiant'=>$_POST['Identifiant_Modifier_AC']));
      $message = 'Modification du rang effectuée';

    }
  }
}

// On fait les tests et requête pour supprimer un utilisateur (seulement pour les admins)
if ($Rang['Rang'] === 'Administrateur') {
  if (isset($_POST['Identifiant_Supprimer_AC'])) {
    if (!empty($_POST['Identifiant_Supprimer_AC'])) {
      $DELETE = $bdd->prepare('DELETE FROM users WHERE Identifiant = :Identifiant');
      $DELETE->execute(array('Identifiant'=>$_POST['Identifiant_Supprimer_AC']));
      $message_delete = 'Suppression effectuée';

    }
  }
}

// On fait test et requête avec la réponse pour modifier l'article (seulement pour les admin)
if(isset($_POST['Titre_Modifier'] , $_POST['Article_Modifier'])){
  if(!empty($_POST['Titre_Modifier']) AND !empty($_POST['Article_Modifier'])){
    $UPDATEArticle = $bdd->prepare('UPDATE actualité SET Titre = :Titre , Article = :Article');
    $UPDATEArticle->execute(array('Titre'=>$_POST['Titre_Modifier'] , 'Article'=>$_POST['Article_Modifier']));
    $messageArticle = 'Veuillez remplir tous les champs';
  }
  else{
    $messageArticle = 'Veuillez remplir tous les champs';
  }
}

 ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="Parametre.css" />
    <link rel="icon" type="image/png" href="Icones/Rugby_union_pictogram.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <title>Paris 2024: Rugby Subaquatique</title>
  </head>

  <body>

  <div class="Inscrit_Bienvenue">Paramètres <?php if ($Rang['Rang'] === 'Administrateur') { echo "Administrateur";} ?></div>
<div id="All-form">
     <form action="Paramètre.php" class="form-Parametre" method='post'>
       <h1>Modifier votre compte</h1>

      <div class ="input_modifier">
        <input type="text" name="Identifiant_Modifier">
        <span data-placeholder="Identifiant"></span>
      </div>
      <div class ="input_modifier">
        <input type="email" name="Email_Modifier">
        <span data-placeholder="Email"></span>
      </div>
      <div class ="input_modifier">
        <input type="password" name="mdp_Modifier">
        <span data-placeholder="Mot de passe"></span>
      </div>
      <div class ="input_modifier">
				<input type="password" name="Confirm_mdp">
				<span data-placeholder="Confirmation du mot de passe"></span>
      </div>
      <center><?php if(isset($reponse)) { echo $reponse; }?></center>
      <input type="submit" class="btnModifier" value="Modifier">

     </form>

     <?php
     // Pour les Admin on affiche toutes les options Administrateur(les différents form) si leur leur rang le permet et ce avec un echo ici pour l'article
     if($Rang['Rang'] === 'Administrateur'){
       echo '
     <form class="form-Actualité" action="Paramètre.php" method="post">
       <h1>Modifier la zone Actualité</h1>

       <div class="input_modifier" id="input_Actualité">
          <input type="text" name="Titre_Modifier">
          <span data-placeholder="Modifier le titre"></span>
       </div>
      <div class="input_modifier" id="input_Actualité">
        <p> Modifier article</p>
        <textarea name="Article_Modifier" rows="9" cols="82" placeholder="Ecrivez votre article ici" class="textarea"></textarea>
      </div>
      <center><?php if(isset($messageArticle)) { echo $messageArticle; }?></center>
      <input type="submit" class="btnModifier" value="Modifier">
     </form>
     ';
     }
     ?>
</div>

<div id="div_autrecompte">
     <?php
     // On affiche le form pour modifier le rang et supprimer un utilisateur 
      if ($Rang['Rang'] === 'Administrateur') {
      echo '
      <form action="Paramètre.php" class="form-autrecompte" method="post">
        <h1>Modifier le rang</h1>

       <div class ="input_modifier">
         <input type="text" name="Identifiant_Modifier_AC">
         <span data-placeholder="Identifiant"></span>
       </div>

       <div class ="input_modifier">
         <input type="text" name="Rang_Modifier_AC">
         <span data-placeholder="Nouveau Rang"></span>
       </div>

       <center><?php if(isset($message)) { echo $message; }?></center>
       <input type="submit" class="btnModifier" value="Modifier">

      </form>

      <form action="Paramètre.php" class="form-delete" method="post">
        <h1>Supprimer un utilsateur</h1>

       <div class ="input_modifier">
         <input type="text" name="Identifiant_Supprimer_AC">
         <span data-placeholder="Identifiant"></span>
       </div>

       <center><?php if(isset($message_delete)) { echo $message_delete; }?></center>
       <input type="submit" class="btnModifier" value="Supprimer">

      </form>
      ';
      }
      ?>
</div>



     <script type="text/javascript">
       $(".input_modifier input").on("focus",function(){
         $(this).addClass("focus");
       });

       $(".input_modifier input").on("blur",function(){
         if($(this).val() == "")
         $(this).removeClass("focus");
       });
     </script>
</div>

  </body>
</html>
