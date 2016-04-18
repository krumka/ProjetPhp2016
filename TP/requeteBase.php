<?php
include("../dbConnectWorld.php");
$answer =$world->query('SELECT * FROM ');//requète
while($donnees=$answer->fetch()){
    $donnees['']
    };
$answer->closeCursor();//ferme le curseur de la bdd
?>