<?php
try
{
/* $bdd = new PDO('mysql:host=localhost;dbname=rugbysubaquatique', 'web', 'Jesuis1mdp'); */
$bdd = new PDO('mysql:host=localhost;dbname=rugbysubaquatique;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

 
//On test si le post du champ utilisateur est défini et différent de NULL
  if (isset($_POST['utilisateur'])) {
	  
	//Premier cas Le champ utilisateur est remplie et pas le champ rang ce qui inclue une requête sql particulière
    if (!empty($_POST['utilisateur']) AND empty($_POST['rang'])) {
      $reqUtilisateur = $bdd->prepare('SELECT Id, Identifiant, Email,Rang FROM users WHERE Identifiant LIKE :Identifiant ORDER BY Id');
      $reqUtilisateur->execute(array('Identifiant'=>'%'.$_POST['utilisateur'].'%'));
      $Nblignes = $reqUtilisateur->rowCount();
      $Utilisateur = $reqUtilisateur->fetchAll(PDO::FETCH_ASSOC);
      $reponse ="Requête effectuer";
	
	//Deuxième cas le champ utilisateur est remplie et le champ rang aussi ce qui inclue une requête sql particulière
    } elseif(!empty($_POST['utilisateur']) AND !empty($_POST['rang'])){
  	  $reqUtilisateur = $bdd->prepare('SELECT Id, Identifiant, Email,Rang FROM users WHERE Identifiant LIKE :Identifiant AND Rang = :rang ORDER BY Id');
      $reqUtilisateur->execute(array('Identifiant'=>'%'.$_POST['utilisateur'].'%' , 'rang'=>$_POST['rang']));
      $Nblignes = $reqUtilisateur->rowCount();
      $Utilisateur = $reqUtilisateur->fetchAll(PDO::FETCH_ASSOC);
      $reponse = "Requête effectuer";
	  
	//Dernier cas Le champ utilisateur n'est pas remplie et le champ rang l'est ce qui inclue une requête sql particulière
    } elseif(empty($_POST['utilisateur']) AND !empty($_POST['rang'])){
  	  $reqUtilisateur = $bdd->prepare('SELECT Id, Identifiant, Email,Rang FROM users WHERE Rang = :rang ORDER BY Id');
      $reqUtilisateur->execute(array('rang'=>$_POST['rang']));
      $Nblignes = $reqUtilisateur->rowCount();
      $Utilisateur = $reqUtilisateur->fetchAll(PDO::FETCH_ASSOC);
      $reponse = "Requête effectuer";
    }
  else{
      $reponse ="Une erreur est survenue";
    }
  }
   else {
    $reponse ="Une erreur est survenue";
  }

 ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="Utilisateurs.css" />
	<link rel="icon" type="image/png" href="Icones/Rugby_union_pictogram.png" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
	<title>Paris 2024: Rugby Subaquatique</title>
  </head>
  <body>
    <form action="ListeUtilisateurs.php" class="form-utilisateurs" method="post">
<h1>Liste des utilisateurs</h1>

<div class ="input_utilisateurs">
  <input type="text" name="utilisateur">
  <span data-placeholder="Utilisateur"></span>
</div>
<div class ="input_utilisateurs">
  <input type="text" name="rang">
  <span data-placeholder="Rang"></span>
</div>

<center><?php if(isset($reponse)) { echo $reponse;}else{echo "Recherche d'utilisateurs ayant un Identifiant similaire";} ?></center></br></br>
<input type="submit" class="btnutilisateurs" value="Rechercher">
</form>

<script type="text/javascript">
$(".input_utilisateurs input").on("focus",function(){
  $(this).addClass("focus");
});

$(".input_utilisateurs input").on("blur",function(){
  if($(this).val() == "")
  $(this).removeClass("focus");
});
</script>

<!-- Si la requête est effectué la variable $Nblignes est défini et différente de NULL ce qui fait que le tableau s'affiche -->
<?php if(isset($Nblignes)){ ?>
<div class="tableau">
<table border="1">
  <thead>
    <tr>
      <th>Id</th>
      <th>Identifiant</th>
      <th>Email</th>
	  <th>Rang</th>
    </tr>
  </thead>
  <tbody>
		<!-- On utilise la variable de la requête ayant subi le fetchall pour afficher chaque ligne et chaque colonnes dans des colonnes et lignes distinct -->
      <?php foreach ($Utilisateur as $row) { ?>
        <tr>
          <td><?php echo $row['Id']; ?></td>
          <td><?php echo $row['Identifiant']; ?></td>
          <td><?php echo $row['Email']; ?></td>
		  <td><?php echo $row['Rang']; ?></td>
        </tr>
      <?php } ?>
  </tbody>
</table>
<?php
} ?>
</div>
  </body>
</html>
