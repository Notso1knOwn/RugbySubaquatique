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


if(isset($_POST['Identifiant'] , $_POST['mdp'])){
    if(!empty($_POST['Identifiant'])  AND !empty($_POST['mdp'])){

          $Identifiant = $_POST['Identifiant'];
		      $mdp = $_POST['mdp'];
          //le hashage du mdp a été commencé et non terminé car non inclus dans le cahier des charges
          $password = password_hash($_POST['mdp'] , PASSWORD_DEFAULT , ['cost' => 12]);
          $_SESSION['Identifiant'] = $Identifiant;
          $_SESSION['mdp'] = $mdp;

				/*try {
					/*$req = 'INSERT INTO users(Identifiant, Email, Mot_de_passe) VALUES(\''.$Identifiant.'\',\''.$email.'\',\''.$mdp.'\')';
					var_dump($req);*/

          // requête pour selectionner identifiant et mdp ayant les valeurs des champs de saisie
					$req = $bdd->prepare('SELECT Identifiant, Mot_de_passe FROM users WHERE Identifiant = :Id AND Mot_de_passe = :mdp');
	        $req->execute(array('Id'=>$Identifiant, 'mdp'=>$mdp));
					$_SESSION['Identifiant'] = $Identifiant;
	      	$message = 'Connexion Effectuée';


          //Redirection vers la page d'accueil
          header('Location: index.php');
			/*	} catch (\Exception $message) {
					$_SESSION['Identifiant'] = NULL;
					$message = 'Identifiant ou mot de passe incorrect';
					$Assurance = NULL;
				}*/
    }
    else {
      //on affiche un message si tous les champs ne sont pas remplis
      $message = 'Veuillez remplir tous les champs';
   }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="login.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
		<title>Login</title>
	</head>

  <body>
    <form action="login.php" class="form-Connexion" method='post'>
      <h1>Connexion</h1>

			<div class ="Id-mdp">
				<input type="text" name="Identifiant">
				<span data-placeholder="Identifiant"></span>
			</div>
			<div class ="Id-mdp">
				<input type="password" name="mdp">
				<span data-placeholder="Mot de passe"></span>
			</div>

			<?php if(isset($message)) { echo $message; } ?>
			<input type="submit" class="btnConnexion" value="Connexion">
			<div class="NewAccount">
				<a href="Inscription.php" target="_blank">Créer un compte</a></br></br>
        <a href="Index.php">Annuler</a>
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
