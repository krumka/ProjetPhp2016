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


/* get the q parameter from URL
$q = $_REQUEST["q"];


$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))){
            if($hint==""){
                $hint=$name;
            }else{
                $hint.=", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?>*/