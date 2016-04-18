<?php
require "inc/mesFonctions.inc.php";
$title = "Accueil";
$siteName = "Nom de mon site";
$logo = "img/04.png";
$altLogo = "logo";
$txtAcc = "Vous avez demandé la page : ";
if(isset($_REQUEST["rq"])){
    $contenu = getContenu($_GET["rq"]);
    die($contenu);
}else{
    include "inc/layout.html.inc.php";
}