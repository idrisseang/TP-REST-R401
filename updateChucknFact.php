<?php

    if(!empty($_GET['id']) && !empty($_GET['phrase'])){
        $id = htmlspecialchars($_GET['id']);
        $phrase=htmlspecialchars(str_replace(' ','',$_GET['phrase']));
    }else {
        $id= htmlspecialchars($_POST['id']);
        $phrase = htmlspecialchars(str_replace(' ','',$_POST['phrase']));
    }

    if(isset($_POST['modifier'])){
        $data = array("id"=>$id,"phrase" => $phrase);
        $data_string = json_encode($data);
        /// Envoi de la requête
        $result = file_get_contents(
        'http://www.kilya.biz/api/chuckn_facts.php',
        false,
        stream_context_create(array(
        'http' => array('method' => 'PUT', // ou PUT
        'content' => $data_string,
        'header' => array('Content-Type: application/json'."\r\n"
        .'Content-Length: '.strlen($data_string)."\r\n"))))
        );
        $result = (array)json_decode($result);
        $status_code = $result['status'];
        
        if($status_code==200){
            echo "<script>alert('La ressource #$id a bien été modifiée');
                window.location.href='client.php';
            </script>";
            
        }
        
    }



?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Put method</title>
</head>
<body>
    <form action="updateChucknFact.php" method="post">
        ID : <input type="text" name="id"  value="<?=$id?>" readonly >
        Phrase : <input type="text" name="phrase" value=<?=$phrase?>>
        <button type="submit" name="modifier">Modifier</button>
    </form>
</body>
</html>