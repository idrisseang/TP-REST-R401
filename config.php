<?php

    try{
        $database = new PDO("mysql:host=localhost;dbname=R401",'root','7878idr');

    }catch(PDOException $e){
        die('Erreur : '.$e->getMessage());
    }


?>