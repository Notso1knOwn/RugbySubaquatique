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

//Bien que fonctionnellement inutile le try abd catch ici à servie pour le débogage 
try {
	//On test si les post des champs datedébut et datefin sont défini et différent de NULL
  if (isset($_POST['datedébut']) && isset($_POST['datefin'])) {
	  
	  //Premier cas les champs datedébut et datefin sont remplie et pas le champ pays ce qui inclue une requête sql propre à ces paramètres
    if (!empty($_POST['datedébut']) AND !empty($_POST['datefin']) AND empty($_POST['pays']) ) {
      $reqEvenement = $bdd->prepare('SELECT * FROM calendrier WHERE Année BETWEEN :debut AND :fin ORDER BY Année');
      $reqEvenement->execute(array('debut'=>$_POST['datedébut'] , 'fin'=>$_POST['datefin']));
      $Nblignes = $reqEvenement->rowCount();
      $Evenement = $reqEvenement->fetchAll(PDO::FETCH_ASSOC);
      $reponse ="Requête effectuer";
	  
	  //Deuxième cas tous les champs sont remplis ce qui inclue une requête sql propre à ces paramètres
    } elseif(!empty($_POST['datedébut']) AND !empty($_POST['datefin']) AND !empty($_POST['pays'])){
  	   $reqEvenement = $bdd->prepare('SELECT * FROM calendrier WHERE Année BETWEEN :debut AND :fin AND Pays = :pays');
      $reqEvenement->execute(array('debut'=>$_POST['datedébut'] , 'fin'=>$_POST['datefin'], 'pays'=>$_POST['pays']));
      $Nblignes = $reqEvenement->rowCount();
      $Evenement = $reqEvenement->fetchAll(PDO::FETCH_ASSOC);
      $reponse = "Requête effectuer";
	  
	  //Deuxième cas seul le champ Pays est rempli ce qui inclue une requête sql propre à ces paramètres
    } elseif(empty($_POST['datedébut']) AND empty($_POST['datefin']) AND !empty($_POST['pays'])){
  	   $reqEvenement = $bdd->prepare('SELECT * FROM calendrier WHERE Pays = :pays');
      $reqEvenement->execute(array('pays'=>$_POST['pays']));
      $Nblignes = $reqEvenement->rowCount();
      $Evenement = $reqEvenement->fetchAll(PDO::FETCH_ASSOC);
      $reponse = "Requête effectuer";
    } 
    else{
      $reponse ="Une erreur est survenue";
    }
  }
  else {
    $reponse ="Veuillez remplir les champs de dates";
  }
} catch (\Exception $exception) {
  die('Erreur : ' . $exception->getMessage());
}
 ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="Calendrier.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <link rel="icon" type="image/png" href="Icones/Rugby_union_pictogram.png" />
    <title>Calendrier</title>
  </head>

  <body>
    <form action="Calendrier.php" class="form-Calendrier" method="post">
    <h1>Calendrier</h1>

    <div class ="input_Calendrier">
      <input type="text" name="datedébut">
      <span data-placeholder="Année de début"></span>
    </div>
    <div class ="input_Calendrier">
      <input type="text" name="datefin">
      <span data-placeholder="Années de fin"></span>
    </div>
	<div class ="input_Calendrier">
      <input type="text" name="pays">
      <span data-placeholder="Pays"></span>
    </div>

    <center><?php if(isset($reponse)) { echo $reponse; }else{echo "Années au format: AAAA";} ?></center></br></br>
    <input type="submit" class="btnCalendrier" value="Rechercher">
  </form>

  <script type="text/javascript">
    $(".input_Calendrier input").on("focus",function(){
      $(this).addClass("focus");
    });

    $(".input_Calendrier input").on("blur",function(){
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
          <th>Année</th>
          <th>Evenement</th>
          <th>Pays</th>
        </tr>
      </thead>
      <tbody>
			<!-- On utilise la variable de la requête ayant subi le fetchall pour afficher chaque ligne et chaque colonnes dans des colonnes et lignes distinct -->
          <?php foreach ($Evenement as $row) { ?>
            <tr>
              <td><?php echo $row['Année']; ?></td>
              <td><?php echo $row['Evenement']; ?></td>
              <td><?php echo $row['Pays']; ?></td>
            </tr>
          <?php } ?>
      </tbody>
    </table>
    <?php
  } ?>
  </div>


  </body>
</html>
