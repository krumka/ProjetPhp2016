<?php
require "inc/mesFonctions.inc.php";
require "inc/config.inc.php";
$conf = new Config();

$title = "Accueil";
$siteName = $conf->getData('site', 'name');
$logo = $conf->getData('image', 'folder')."/".$conf->getData('logo', 'name');
$altLogo = $conf->getData('logo', 'alt');
$txtAcc = "Vous avez demandé la page : ";
if(isset($_GET["rq"])){
    $contenu = getContenu($_GET["rq"]);
    die($contenu);
}else{
    $contenu=getContenu("accueil");
    include "inc/layout.html.inc.php";
}