<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<link rel="Shortcut Icon" href="img/head.png" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		<?php echo $title ?>
	</title>
	<!-- La feuille de styles "base.css" doit être appelée en premier. -->
	<link rel="stylesheet" type="text/css" href="css/base.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/modele04.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/site.css" media="all" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
</head>

<body>

<div id="global">

	<header>
		<h1>
			<img alt="<?php echo $altLogo ?>" src="<?php echo $logo ?>" />
			<span><?php echo $siteName ?></span>
		</h1>
		<nav id="menu" class="menu">
			<?php echo creerMenu($lesMenus['menu']) ?>
		</nav>
	</header><!-- #entete -->

	<nav id="sous-menu" class="menu">
		<?php echo creerMenu($lesMenus['sous-menu']) ?>
	</nav><!-- #navigation -->

	<main>
		<p id="txtAccueil"></p>
	</main><!-- #contenu -->

	<footer>
		Mise en page &copy; 2008
		<a href="http://www.elephorm.com">Elephorm</a> et
		<a href="http://www.alsacreations.com">Alsacréations</a>
	</footer>

</div><!-- #global -->

</body>
</html>
