<?php
session_start();
require "nav.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <link href="css/demoSession.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
echo nav("Get01");
// Echo session variables that were set on previous page
echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
echo "Favorite animal is " . $_SESSION["favanimal"] . ".";
?>

</body>
</html>