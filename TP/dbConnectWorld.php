<?php
    try{
        $world = new PDO('mysql:host=localhost;dbname=world', 'LAMBINET', 'RemyY3e2',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
?>