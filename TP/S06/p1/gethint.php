<?php
// Array with names
include "../../dbConnectMiniCampus.php";
$request = "SELECT nom FROM class";
$answer = $world->query($request);
$a = [];
while($donnees=$answer->fetch()){
    array_push($a,$donnees['nom']);
};

// get the q parameter from URL
$q = $_REQUEST["q"];
$w = $_REQUEST["w"];


$suggest = [];
$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    if($w=="in"){
        foreach($a as $name) {
            if (strripos($name, $q) !== false){
                array_push($suggest, array($name, $name));
            }
        }
    }else if($w=="begin"){
        foreach($a as $name) {
            if (stristr($q, substr($name, 0, $len))){
                array_push($suggest, array($name, $name));
            }
        }
    }else if($w=="end") {
        foreach($a as $name) {
            if (stristr($q, substr($name, -$len))){
                array_push($suggest, array($name, $name));
            }
        }
    }
}

if(count($suggest)<=10){
    $count = count($suggest);
}else{
    $count = 10;
}

$hint = "\n\t<select size=".$count." name=\"sugg\" id=\"".$name."\" >";
foreach($suggest as $item){
    $hint .= "\n\t\t<option value=\"".$item[0]."\" onclick=\"showCourses(this.value);\" ";
    $hint .= ">".$item[1]."</option>";
}
$hint .= "\n\t</select>";

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?>