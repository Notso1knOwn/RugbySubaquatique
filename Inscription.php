<?php
session_start();
try
{
/* $bdd = new PDO('mysql:host=localhost;dbname=rugbysubaquatique', 'web', 'Jesuis1mdp'); */
$bdd = new PDO('mysql:host=localhost;dbname=rugbysubaquatique;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// On fait les trois test si les post sont défini et non NULL, si les post ne sont pas "vides" et enfin si les chanps mdp sont égaux
if(isset($_POST['Identifiant'] , $_POST['email'] , $_POST['mdp'] , $_POST['Confirm_mdp'])){
    if(!empty($_POST['Identifiant']) AND !empty($_POST['email']) AND !empty($_POST['mdp']) AND !empty($_POST['Confirm_mdp'])){
      if($_POST['mdp'] == $_POST['Confirm_mdp']){

        // Pour nous simplifié on met les post dans des variables
        $Identifiant = $_POST['Identifiant'];
        $mdp = $_POST['mdp'];
        $email = $_POST['email'];

        //Ayant besoin des valeur post dans d'autres pages on les met dant des sessions
        $_SESSION['Identifiant'] = $Identifiant;
        $_SESSION['mdp'] = $mdp;

        /*$req = 'INSERT INTO users(Identifiant, Email, Mot_de_passe) VALUES(\''.$Identifiant.'\',\''.$email.'\',\''.$mdp.'\')';
        var_dump($req);*/

        //Enfin on fait la requête pour insérer dans la bdd les valeurs dans les champs
        $ins = $bdd->prepare('INSERT INTO users(Identifiant, Email, Mot_de_passe) VALUES(:Id, :Email, :mdp)');
        $ins->execute(array('Id'=>$Identifiant, 'Email'=>$email, 'mdp'=>$mdp));
        $reponse = 'Inscription terminé';

      //Redirection vers la page d'accueil
      header('Location: index.php');
      }
      else {
        //message si les mdp sont différents dans le but que l'utilisateur ai un retour
        $reponse = 'Le Mot de passe est différent sur les deux champs';
        $_SESSION['Identifiant'] = NULL;
      }
    }
    else {
      //message si tous les champs ne sont pas remplis
      $reponse = 'Veuillez remplir tous les champs';
   }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="login.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
		<title>Inscription</title>
	</head>

  <body>
      <form action="Inscription.php" class="form-Connexion" method="post">
      <h1>Inscription</h1>

			<div class ="Id-mdp">
				<input type="text" name="Identifiant">
				<span data-placeholder="Identifiant"></span>
			</div>
			<div class ="Id-mdp">
				<input type="email" name="email">
				<span data-placeholder="Email"></span>
			</div>
      <div class ="Id-mdp">
				<input type="password" name="mdp">
				<span data-placeholder="Mot de passe"></span>
			</div>
      <div class ="Id-mdp">
				<input type="password" name="Confirm_mdp">
				<span data-placeholder="Confirmation du mot de passe"></span>
			</div>

			<input type="submit" class="btnConnexion" value="Inscription">
			<div class="NewAccount">
                            <?php if(isset($reponse)) { echo $reponse; } ?></br></br>
                            <a href="index.php">Annuler</a>
			</div>
    </form>

		<script type="text/javascript">
			$(".Id-mdp input").on("focus",function(){
				$(this).addClass("focus");
			});

			$(".Id-mdp input").on("blur",function(){
				if($(this).val() == "")
				$(this).removeClass("focus");
			});
		</script>
  </body>
</html>
