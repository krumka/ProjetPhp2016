<?php
    $conf = new Config();
    try{
        $db = new PDO("mysql:host=".$conf->getData("db", "host").";dbname=".$conf->getData("db", "dbname"), $conf->getData("db", "user"), $conf->getData("db", "pswd"),array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }catch (PDOException $e) {
        sendMessage('error', 'Erreur Sql', 'Erreur PDO : ' . utf8_encode($e->getMessage()));
    }