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
echo nav("Print_r");
// to change a session variable, just overwrite it
$_SESSION["favcolor"] = "yellow";
print_r($_SESSION);
?>

</body>
</html>