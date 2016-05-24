<!DOCTYPE html>
<html>
<head>
	<link rel="Shortcut Icon" href="img/head.png" />
	<title>
		<?php echo $title ?>
	</title>
    <!-- Pour le canvas -->
    <link rel="stylesheet" href="css/Paint.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/colorpicker.js"></script>
    <script type="text/javascript" src="js/eye.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
    <script type="text/javascript" src="js/layout.js?ver=1.0.2"></script>
    <link rel="stylesheet" href="css/colorpicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />
    <script src="js/Paint.js"></script>
	<!-- La feuille de styles "base.css" doit être appelée en premier. -->
	<link rel="stylesheet" type="text/css" href="css/base.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/modele04.css" media="screen" />
    <!--  JQuery + JQuery UI	-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/smoothness/jquery-ui.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <!-- Colorpicker JQuery -->
    <script type="text/javascript" src="js/colorpicker.js"></script>
	<!-- Pour DataTables -->
	<link rel="stylesheet" type="text/css" href="css/datatables.css"/>
	<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
	<!-- Perso -->
	<script type="text/javascript" src="js/index.js"></script>
	<link rel="stylesheet" type="text/css" href="css/site.css" media="all" />
</head>

<body>

<div id="global">

	<header>
		<h1>
			<img id="logo" alt="<?php echo $_SESSION['altLogo'] ?>" src="<?php echo $_SESSION['logo'] ?>" />
			<span id="title"><?php echo $_SESSION['siteName'] ?></span>
		</h1>
		<nav id="menu" class="menu">
			<?php echo creerMenu(setMenu()) ?>
		</nav>
		<div id="alerte"></div>
	</header><!-- #entete -->

	<nav id="sous-menu" class="menu">
	</nav><!-- #navigation -->

	<main>
		<div id="contenu"></div>
		<div id="message"></div>
	</main><!-- #contenu -->

	<footer>
		Mise en page &copy; 2008
		<a href="http://www.elephorm.com">Elephorm</a> et
		<a href="http://www.alsacreations.com">Alsacréations</a>
	</footer>

</div><!-- #global -->

</body>
</html>
