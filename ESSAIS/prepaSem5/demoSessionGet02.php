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
echo nav("Get02");
print_r($_SESSION);
?>

</body>
</html>