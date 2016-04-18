<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="css/ex7.css">
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

<?php //Fonctions
    function today(){
        return date("d-m-Y");
    }
    function hour(){
        return date("H:i");
    }
?>