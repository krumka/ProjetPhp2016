<?php
// Array with names
include "../../dbConnectMiniCampus.php";
require "layout.php";
$c = $_REQUEST["c"];
$sql = "SELECT code, faculte, intitule FROM cours
        INNER JOIN course_class ON cours.code=course_class.cours_id
        INNER JOIN class ON course_class.class_id=class.id
        WHERE class.nom=\"".$c."\"
        ORDER BY code;";
$listTab[0] = array("Code", "Faculté", "Intitulé");
$answer = $world->query($sql);//requète

while($datas = $answer->fetch()){
    array_push($listTab, array($datas['code'], $datas['faculte'], $datas['intitule']));
};
$answer->closeCursor();
$tab = new Tableau($listTab, "Cours pour le groupe " . $c, true, 3);
echo $tab->html();