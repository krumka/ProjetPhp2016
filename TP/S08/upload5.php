<?php
$target_dir = "avatars2/";
print_r($_FILES["fileToUpload"]);
$ext = explode( ".", basename($_FILES["fileToUpload"]["name"]));
$ext = $ext[count($ext)-1];
$target_file = $target_dir . $_POST["name"] . "." . $ext;
echo "</br>". $target_file. "</br>";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".</br>";
        $uploadOk = 1;
    } else {
        echo "</br>File is not an image.</br>";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "</br>Sorry, file already exists.</br>";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 20000000) {
    echo "</br>Sorry, your file is too large.</br>";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "png") {
    echo "</br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</br>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "</br>Sorry, your file was not uploaded.</br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "</br>The file ". $target_file. " has been uploaded.</br>";
    } else {
        echo "</br>Sorry, there was an error uploading your file.</br>";
    }
}

//--------------------------------------------------RESIZE----------------------------------------------------------------------------------
// Définition de la largeur et de la hauteur maximale
$width = 150;
$height = 150;

// Cacul des nouvelles dimensions
list($width_orig, $height_orig) = getimagesize($target_file);

$ratio_orig = $width_orig/$height_orig;

if ($width/$height > $ratio_orig) {
    $width = $height*$ratio_orig;
} else {
    $height = $width/$ratio_orig;
}

// Redimensionnement
$image_p = imagecreatetruecolor($width, $height);
imagealphablending( $image_p, false );
imagesavealpha( $image_p, true );

if($imageFileType == "jpeg" || $imageFileType == "jpg") {
    $image = imagecreatefromjpeg($target_file);
}else if($imageFileType == "png"){
    $image = imagecreatefrompng($target_file);
}else if($imageFileType == "gif"){
    $image = imagecreatefromgif($target_file);
}else{
    echo "</br>Redimensionnement de l'image impossible</br>";
}

if($image!=false){
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
}else{
    echo "</br>Redimensionnement de l'image impossible</br>";
}

// Affichage
if($imageFileType == "jpeg" || $imageFileType == "jpg") {
    imagejpeg($image_p, $target_file);
    echo "</br>Redimensionnement de l'image fait : jpg</br>";
}else if($imageFileType == "png"){
    imagepng($image_p, $target_file);
    echo "</br>Redimensionnement de l'image fait : png</br>";
}else if($imageFileType == "gif"){
    imagegif($image_p, $target_file);
    echo "</br>Redimensionnement de l'image fait : gif</br>";
}else{
    echo "</br>Redimensionnement de l'image impossible</br>";
}

//---------------------------------------------------END-------------------------------------------------------------------------------------
echo "</br>Voir le fichier : <a href=\"".$target_file."\">".$target_file."</a>";