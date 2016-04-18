<?php require "phpFunctions/ex9.inc.php"; ?>
<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="css/ex9.css">
</head>
<body>
<?php
$date = today(0);
$hour = today(1);
echo "<span id=date>".$date."</span>";
echo "<span id=hour>".$hour."</span>";
?>
</body>
</html>