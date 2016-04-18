<?php
    include("../../dbConnectWorld.php");
    $answer =$world->query('SELECT * FROM country');//requète
    echo "<ul>";
    while($donnees=$answer->fetch()){
        echo "<li>".$donnees['Name']."</li>";
    };
    echo "</ul>";
    $answer->closeCursor();//ferme le curseur de la bdd
?>