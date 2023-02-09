<?php

    if(isset($_GET) && !empty($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $result = file_get_contents("http://www.kilya.biz/api/chuckn_facts.php?id=$id",false,stream_context_create(array('http' => array('method' => 'DELETE'))));
        $resultat = (array)json_decode($result);
        $status_code = $resultat['status'];
        if($status_code==200){
            echo "<script>alert('La ressource #$id a bien été supprimée');
                window.location.href='client.php';
            </script>";
            
        }
    }else header("Location:client.php");


?>