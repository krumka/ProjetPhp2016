<?php require "phpFunctions/ex8.inc.php"; ?>
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" href="css/ex8.css">
    </head>
    <body>
        <?php
        $date = today();
        $hour = hour();
        echo "<span id=date>".$date."</span>";
        echo "<span id=hour>".$hour."</span>";
        ?>
    </body>
</html>