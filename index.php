<?php	/*
session_start();
if(isset($Actualité) AND $rang == 2){		//On met au préalable dans la variable rang le rang de l'user
	//On met le menu déroulant en remplaçant l'icone connection avec (paramètre, modification, déconnexion)
	//On met ici les liens vers la page de modification des paramètres du tuple dans la BDD
}*/
try
{
/* $bdd = new PDO('mysql:host=localhost;dbname=rugbysubaquatique', 'web', 'Jesuis1mdp'); */
$bdd = new PDO('mysql:host=10.0.10.137:3306;dbname=rugbysubaquatique;charset=utf8', 'root', 'root');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
 ?>
<! DOCTYPE html>				<!-- Page d'Adrien -->
<html>
	<head>
		<!-- On défini le type d'encodage -->
		<meta charset="utf-8" />
		<!-- Le plus important le lien vers les documents css -->
		<link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="Bouttonancre.css" />
    <link rel="stylesheet" href="footer.css" />
		<!-- Le titre qui se met dans l'onglet. -->
		<link rel="icon" type="image/png" href="Icones/Rugby_union_pictogram.png" />
		<!-- Le logo qui se met dans l'onglet. Ici j'airais très bien pu raccourcir le code en mettant l'image en format ".ico"
		mais cela fonctionne aussi avec le png. -->
		<title>Paris 2024: Rugby Subaquatique</title>
	</head>

	<body>
    <?php include("Connexion.php"); ?>

		<!-- On va fait le semblant de header à rappeller que la navbar n'est pas existante pour cette page,
		nous avons décidé d'un commun accord de ne pas faire une navbar en position sticky ou fixed mais
		une navbar plus indirect avec des boutons en postion vertical avec un affichage au survol du texte
		indiquant le titre. -->
		<section class="Accueil">
			<h1>ACCUEIL</h1>
			<div class="raccourcisaccueil">
				<!-- la balise a couplet a href permet de faire lien et la balise boutton car c'est une balise faite pour les bouttons -->
				<a href="#Actualités"><button class="button">Actualités</button></a>
				<a href="#Histoire"><button class="button1">Histoire</button></a>
				<a href="Reglement-Histoire.html?#Réglement"><button class="button2">Réglement</button></a>
				<a href="Reglement-Histoire.html?#Champions"><button class="button3">Champions</button></a>
			</div>
		</section>

        <?php include("nav_bar_verticale.php"); ?>


		<!-- Voila une section avec ses div et son contenu de type blabla. A préciser que je n'utilise les id que pour les gros titres pour tous les autres j'utilise des class
	 	même si dans la logique il faudrait utiliser des id. -->
		<section class="section1">
			<h1 id="Actualités">Actualités</h1>

			<!-- On encadre le texte et l'image d'une div pour permettre l'adaptabilité de résolution dans le css. -->
			<div class="all1">
			<img src="Images/image.jpg" class="imageactu" alt="Image d'actualité">
			<div class="boxtext">
			<h2><?php
        $reqTitre = $bdd->query('SELECT Titre FROM actualité');
        $Titre = $reqTitre->fetch();
        echo $Titre['Titre'];
       ?></h2><br>
			<p><?php
        $reqArticle = $bdd->query('SELECT * FROM actualité');
        $Article = $reqArticle->fetch();
        echo $Article['Article'];
      ?></p>

		</div>
		</div>
		</section>


		<!-- Même chose que la première section. -->
		<section class="section2">
			<h1 id="Histoire">Histoire</h1>

			<div class="boxtext2">
				<p>
				Ce sport est apparu en 1961 grâce à Ludwig von Bersuda, alors membre du club de plongée de Cologne (DUC-koeln). Il cherchait un moyen de rendre l'entraînement plus amusant. Pour cela, il eut l'idée d'un jeu de ballon sous l'eau. Or les ballons classiques remplis d'air n'étant pas adaptés, il remplit la balle d'eau salée. Puisque la densité du ballon était désormais supérieure à celle de l'eau, il ne flottait plus à la surface, mais coulait lentement vers le fond, la vitesse de chute pouvant, dans certaines limites, être contrôlée par la concentration de la solution saline. C'est une balle de water-polo qui fut utilisée, le ballon de football étant trop grand et donc peu pratique sous l'eau.<br><br>
Ludwig von Bersuda disposa au milieu de la piscine un filet, comme au volley-ball, qui s'arrêtait à 1 mètre du fond de la piscine. Deux équipes jouaient l'une contre l'autre: l'équipe offensive devait porter le ballon dans le terrain adverse et le mettre dans un seau. L'idée du jeu était prête et le Cologne-DUC l'utilisa en tant qu'exercice d'échauffement avant l'entraînement. D'autres équipes s'en aperçurent et commencèrent à utiliser des ballons remplis d'eau de mer à leur tour.<br><br>
La « discipline de Cologne » fut présentée comme sport de compétition aux Jeux nationaux en 1963. Ce fut probablement le premier match officiel avec une balle sous-marine. À l'époque, cependant, peu d'intérêt fut affiché pour ce sport.<br><br>
Docteur Franz Josef Grimmeisen, membre du club de plongée de Duisbourg (DUC-Duisburg), décida d'organiser une compétition de ce jeu. L'association des maîtres nageurs de Mülheim an der Ruhr (DLRG Mülheim) pris contact auprès de membres du DUC-Duisburg afin d'apprendre les règles de ce nouveau sport. Avec leur aide, Grimmeisen organisa le premier match de rugby subaquatique le 4 octobre 1964. Les équipes du DLRG Mülheim et du DUC Duisburg s'affrontèrent. Le club de plongée de Duisbourg gagna le match 5-2. Les médias prirent note de cette « première » et dans l'édition suivante du Essener Tageblatt, il y eut une demi page avec 2 photos.<br><br>
Grimmeisen, toujours dans l'idée d'organiser une compétition de rugby subaquatique, réunit 6 équipes à Mülheim an der Ruhr le 5 novembre 1965. Les clubs de plongée de Mülheim, de Bochum, de Düsseldorf, de Duisbourg, d'Essen et le TSC Delphin de Ludenscheid y prirent part. À l'époque, les équipes n'étaient constituées que de 8 joueurs. Le club organisateur, le DLRG Mülheim, gagna la compétition face à DUC Duisburg (équipe dans laquelle jouait le Dr Grimmeisen).<br><br>
Le tournoi a lieu chaque année depuis, ce qui en fait le plus ancien tournoi de l'histoire de ce sport. La version initiale telle qu'elle se jouait à Cologne ne dura pas, même le club de Cologne se mua en club de rugby subaquatique.<br><br>
Pour amener ce sport dans l'arène internationale, Grimmeisen se tourna vers les deux plus importantes Confédération mondiale des activités subaquatiques, la France et l'URSS. Il proposa des démonstrations, malheureusement aucun intérêt ne fut témoigné, seul le journal français L'Équipe publia un court article dans son édition du 9 avril 1965.<br><br>
Les pays scandinaves montrèrent rapidement de l'intérêt pour ce sport. Les démonstrations au Danemark en 1973, en Finlande en 1975 rencontrèrent un certain succès. Dans le bloc de l'Est, seule la République tchèque adopta ce sport, mais n'accepta de jouer que contre des équipes communistes.<br><br>
En 1972, lorsque le rugby subaquatique fut reconnu comme sport officiel par la VDST (Union des plongeurs allemands), eut lieu le premier championnat. Cette compétition se déroula à Mülheim et fut remportée par l'équipe locale.<br><br>
En 1978, le rugby subaquatique et le hockey subaquatique furent officiellement reconnus par la Confédération mondiale des activités subaquatiques (CMAS). Les premiers championnats européens se déroulèrent du 28 au 30 avril 1978 à Malmö (Suède).<br><br>
La première compétition mondiale a eu lieu en 1980 à Mülheim, ville où ce sport est né.<br><br>
En France c'est à Bordeaux qu'il a émergé en 2014. Aujourd'hui, il y a 5 clubs en France, à Bordeaux, Albi,Toulouse, Puy-l'Évêque et Paris. La première rencontre nationale de rugby subaquatique a eu lieu dans la ville d'Albi en 2019, avec la victoire de Bordeaux, suivi de Toulouse en deuxième place, Albi troisième et Puy-l'Évêque quatrième.
			</p>
		</div>
		</section>


    <!-- footer dans une autre page php que l'om appèle ici -->
    <?php include("footer.php"); ?>
	</body>
</html>
