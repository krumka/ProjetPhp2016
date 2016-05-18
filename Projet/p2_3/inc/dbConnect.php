<?php
    try{
        $world = new PDO('mysql:host=localhost;dbname=world', 'LAMBINET', 'RemyY3e2',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }catch (PDOException $e) {
        sendMessage('error', 'Erreur Sql', 'Erreur PDO : ' . utf8_encode($e->getMessage()));
    }