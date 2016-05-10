<?php
session_start();
require "inc/mesFonctions.inc.php";
require "inc/config.inc.php";
if(!isset($_SESSION['sessionId'])){
    $_SESSION['comingDate'] = date("d/m/y G:i:s");
    $_SESSION['sessionId'] = explode(";", explode("=", getallheaders()['Cookie'])[1])[0];
    $conf = new Config();
    $_SESSION['siteName'] = $conf->getData('site', 'name');
    $_SESSION['logo'] = $conf->getData('image', 'folder')."/".$conf->getData('logo', 'name');
    $_SESSION['altLogo'] = $conf->getData('logo', 'alt');
}
$title = "Accueil";
if(isset($_GET["rq"])){
    $contenu = getContenu($_GET["rq"]);
    die($contenu);
}else{
    $contenu=getContenu("accueil");
    include "inc/layout.html.inc.php";
}