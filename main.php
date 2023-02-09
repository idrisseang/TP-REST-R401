<?php

////////////////// Cas des méthodes GET et DELETE //////////////////
$result = file_get_contents('URL_de_la_ressource',
false,
stream_context_create(array('http' => array('method' => 'GET'))) // ou DELETE
);
////////////////// Cas des méthodes POST et PUT //////////////////
/// Déclaration des données à envoyer au Serveur
$data = array("key 1" => "value 1", "key 2" => "value 2");
$data_string = json_encode($data);
/// Envoi de la requête
$result = file_get_contents(
'URL_de_la_ressource',
null,
stream_context_create(array(
'http' => array('method' => 'POST', // ou PUT
'content' => $data_string,
'header' => array('Content-Type: application/json'."\r\n"
.'Content-Length: '.strlen($data_string)."\r\n"))))
);
/// Dans tous les cas, affichage des résultats
echo '<pre>' . htmlspecialchars($result) . '</pre>';




?>