<?php
// Start the session
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
echo nav("Start");
// Set session variables
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
?>

</body>
</html>