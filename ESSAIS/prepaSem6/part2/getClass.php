<?php
// Array with names
include "../../../TP/dbConnectMiniCampus.php";
$request = "SELECT * FROM class";
$answer = $world->query($request);
$a = [];
while($donnees=$answer->fetch()){
    $d = [];
    $d['id']=$donnees['id'];
    $d['nom']=$donnees['nom'];
    $d['parent_id']=$donnees['parent_id'];
    $d['niveau']=$donnees['niveau'];
    array_push($a,$d);
};

echo json_encode($a);