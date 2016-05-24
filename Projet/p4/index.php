<?php
session_start();
require "inc/mesFonctions.inc.php";
require "inc/config.inc.php";
require "inc/Class.php";
if(!isset($_SESSION['comingDate'])){
    $_SESSION['comingDate'] = date("d/m/y G:i:s");
    $conf = new Config();
    $_SESSION['siteName'] = $conf->getData('site', 'name');
    $_SESSION['logo'] = $conf->getData('image', 'folder')."/".$conf->getData('logo', 'name');
    $_SESSION['altLogo'] = $conf->getData('logo', 'alt');
    chargeProfil();
    genereStatuts(true);
}
setMenu();
$title = "Accueil";
if(isset($_GET["rq"])){
    $_SESSION['rqLog'][time()]=$_GET['rq'];
    global $envoi;
    traiteRequest($_GET['rq']);
    die(json_encode($envoi));
}else{
    include "inc/layout.html.inc.php";
}