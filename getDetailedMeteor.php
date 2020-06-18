<?php
    // Config
    include './includes/config.php';

    // Select meteors
    $query = $pdo->prepare('SELECT id, name, recclass, mass, found, year, reclat, reclong FROM meteorite_landings WHERE id = :id');
    $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $query->execute();
    $meteor = $query->fetch();

    // Fetch OpenCage API
    $url = 'https://api.opencagedata.com/geocode/v1/json?q='.$meteor->reclat.'+'.$meteor->reclong.'&key='.OPEN_CAGE_API_KEY;
    $data = @file_get_contents($url);
    $data = json_decode($data);

    $meteor->city = $data->results[0]->components->city;
    $meteor->country = $data->results[0]->components->country;
    $meteor->flag = $data->results[0]->annotations->flag;

    echo json_encode($meteor);