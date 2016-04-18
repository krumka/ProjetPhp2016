<?php
// Array with names
include "../../../../TP/dbConnectMiniCampus.php";
$request = "SELECT nom FROM class";
$answer = $world->query($request);
$a = [];
while($donnees=$answer->fetch()){
    array_push($a,$donnees['nom']);
};

// get the q parameter from URL
$q = $_REQUEST["q"];
$w = $_REQUEST["w"];


$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    if($w=="in"){
        foreach($a as $name) {
            if (strripos($name, $q) !== false){
                if($hint==""){
                    $hint=$name;
                }else{
                    $hint.=", $name";
                }
            }
        }
    }else if($w=="begin"){
        foreach($a as $name) {
            if (stristr($q, substr($name, 0, $len))){
                if($hint==""){
                    $hint=$name;
                }else{
                    $hint.=", $name";
                }
            }
        }
    }else if($w=="end") {
        foreach($a as $name) {
            if (stristr($q, substr($name, -$len))){
                if($hint==""){
                    $hint=$name;
                }else{
                    $hint.=", $name";
                }
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?>