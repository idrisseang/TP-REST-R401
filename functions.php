<?php


    function useAPI($methode,$URL){
        $result = file_get_contents("$URL",false,stream_context_create(array('http' => array('method' => "$methode"))));
        $resultat = (array)json_decode($result);
        switch($methode){
            case "GET":
                $data = (array)$resultat['data'];
            break;
        }
        return $data;
    }




?>