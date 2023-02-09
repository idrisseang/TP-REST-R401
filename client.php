<?php
    include 'functions.php';

    if(isset($_POST['seeAll'])){
        $data = useAPI("GET",'http://www.kilya.biz/api/chuckn_facts.php');
    }else $data = null;

if(isset($_POST['ajouter'])){
    $phrase = htmlspecialchars($_POST['phrase']);
    $data = array("phrase" => $phrase);
    $data_string = json_encode($data);
    /// Envoi de la requête
    $result = file_get_contents(
    'http://www.kilya.biz/api/chuckn_facts.php',
    false,
    stream_context_create(array(
    'http' => array('method' => 'POST', // ou PUT
    'content' => $data_string,
    'header' => array('Content-Type: application/json'."\r\n"
    .'Content-Length: '.strlen($data_string)."\r\n"))))
    );
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" 
crossorigin="anonymous">
    <title>Client ChucknFacts</title>
</head>
<body>
    <form action="client.php" method="post">
        Entrez la phrase à ajouter : <input type="text" name="phrase">
        <div><button type="submit" name="seeAll">Voir toutes les données</button></div>
        <div><button type="submit" name="ajouter">Ajouter</button></div>
    </form>
    <?php if($data!=null) : ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Phrase</th>
                <th>Vote</th>
                <th>Date_ajout</th>
                <th>Date_modif</th>
                <th>Faute</th>
                <th>Signalement</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $dt): $dt = (array) $dt?>
            <tr>
                <td>#<?=$dt['id']?></td>
                <td><?=$dt['phrase']?></td>
                <td><?=$dt['vote']?></td>
                <td><?=$dt['date_ajout']?></td>
                <td><?=$dt['date_modif']?></td>
                <td><?=$dt['faute']?></td>
                <td><?=$dt['signalement']?></td>
                <td><a target=_blank href="<?="updateChucknFact.php?id=".$dt['id']."&phrase=".$dt['phrase']?>">Modifier</a></td>
                <td><a href=<?= "deleteChucknFact.php?id=".$dt['id'] ?>>Supprimer</a></td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
    <?php endif ?>
    
    
</body>
</html>