<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/upform.js"></script>
</head>
<body>

<form action="upload6.php" method="post" enctype="multipart/form-data">
    <p>Id de l'image : <input type="number" name="id" id="id"></p>
    <img id="avatar"></br>
    Select image to upload:
    <input type="file" name="fileToUpload" height="200" id="fileToUpload">
    <input type="submit" value="Upload" disabled name="submit">
</form>
<p>Taille : <span id="size">0 Bytes</span></p>

</body>
</html>