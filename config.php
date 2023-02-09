<?php

    try{
        $database = new PDO("mysql:host=localhost;dbname=R401",'root','');

    }catch(PDOException $e){
        die('Erreur : '.$e->getMessage());
    }


?>
