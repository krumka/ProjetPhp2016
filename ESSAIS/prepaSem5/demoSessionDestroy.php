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
echo nav("Destroy");
// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>

</body>
</html>