<?php
    require_once 'config.php';
    
    /// Paramétrage de l'entête HTTP (pour la réponse au Client)
    header("Content-Type:application/json");
    /// Identification du type de méthode HTTP envoyée par le client
    $http_method = $_SERVER['REQUEST_METHOD'];
    switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        function getAllData($database){
            $query = "SELECT * FROM chuckn_facts";
            $select = $database->prepare($query);
            $select->execute(array());
            $data = $select -> fetchAll();
            return $data;
        }
        $matchingData = getAllData($database);
    if (!empty($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        function getRessourceById($database,$id){
            $query = "SELECT * FROM chuckn_facts WHERE id=?";
            $select = $database->prepare($query);
            $select->execute(array($id));
            $data = $select -> fetch();
            return $data;
        }
        $matchingData = getRessourceById($database,$id);
    }
    /// Envoi de la réponse au Client
    deliver_response(200, "[LOCAL SERVEUR REST] GET REQUEST : Read Data OK", $matchingData);
    break;
    /// Cas de la méthode POST
    case "POST" :
    $postedData = json_decode(file_get_contents('php://input'));
    $query = "INSERT INTO chuckn_facts(phrase,vote,date_ajout,date_modif,faute,signalement)VALUES(?,?,?,?,?,?)";

    $maData = (array)$postedData;
    $phrase = $maData['phrase'];
    $vote = $maData['vote'];
    $date_ajout = $maData['date_ajout'];
    $date_modif = $maData['date_modif'];
    $faute = $maData['faute'];
    $signalement = $maData['signalement'];

    $insert = $database->prepare($query);
    $insert->execute(array($phrase,$vote,$date_ajout,$date_modif,$faute,$signalement));

    deliver_response(201, "[LOCAL SERVEUR REST] POST REQUEST : Insert Data OK", NULL);
    break;
    /// Cas de la méthode PUT
    case "PUT" :
    /// Récupération des données envoyées par le Client
    $postedData = json_decode(file_get_contents('php://input'));
    $maData = (array)$postedData;
    $id = $maData['id'];
    $phrase = $maData['phrase'];
    $vote = $maData['vote'];
    $date_ajout = $maData['date_ajout'];
    $date_modif = $maData['date_modif'];
    $faute = $maData['faute'];
    $signalement = $maData['signalement'];

    $query = "UPDATE chuckn_facts SET phrase=?,vote=?,date_ajout=?,date_modif=?,faute=?,signalement=? WHERE id=?";
    $update = $database -> prepare($query);
    $update -> execute(array($phrase,$vote,$date_ajout,$date_modif,$faute,$signalement,$id));
    deliver_response(200, "[LOCAL SERVEUR REST] PUT REQUEST : UPDATE Data OK", NULL);
    break;
    
    case "DELETE":
        if(!empty($_GET['id'])){
            $id = htmlspecialchars($_GET['id']);
            $query = "DELETE FROM chuckn_facts WHERE id=$id";
            $delete = $database->prepare($query);
            $delete ->execute(array());
        }
        deliver_response(200, "[LOCAL SERVEUR REST] DELETE REQUEST : DELETE Data OK", NULL);

    default:
    break;
    }
    /// Envoi de la réponse au Client
    function deliver_response($status, $status_message, $data){
    /// Paramétrage de l'entête HTTP, suite
    header("HTTP/1.1 $status $status_message");
    /// Paramétrage de la réponse retournée
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    /// Mapping de la réponse au format JSON
    $json_response = json_encode($response);
    echo $json_response;
}
?>