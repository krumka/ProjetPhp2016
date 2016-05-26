<?php
include("../dbConnectWorld.php");
$answer =$world->query('SELECT * FROM ');//requète
//ou bien :
//$req = $bdd->prepare('INSERT INTO jeux_video(nom, possesseur, console, prix, nbre_joueurs_max, commentaires) VALUES(:nom, :possesseur, :console, :prix, :nbre_joueurs_max, :commentaires)');
//$req->execute(array(
//    'nom' => $nom,
//    'possesseur' => $possesseur,
//    'console' => $console,
//    'prix' => $prix,
//    'nbre_joueurs_max' => $nbre_joueurs_max,
//    'commentaires' => $commentaires
//));
while($donnees=$answer->fetch()){
    $donnees[''];
    };
$answer->closeCursor();//ferme le curseur de la bdd
?>