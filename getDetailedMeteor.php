<?php
    // Config
    include './includes/config.php';

    // Select meteors
    $query = $pdo->prepare('SELECT id, name, recclass, mass, found, year, reclat, reclong FROM meteorite_landings WHERE id = :id');
    $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $query->execute();
    $meteor = $query->fetch();

    // Fetch OpenCage API
    if(!empty($meteor->reclat) || !empty($meteor->reclong)){
        $url = 'https://api.opencagedata.com/geocode/v1/json?q='.$meteor->reclat.'+'.$meteor->reclong.'&key='.OPEN_CAGE_API_KEY;
        $data = @file_get_contents($url);
        $data = json_decode($data);

        // City
        if(!empty($data->results[0]->components->city)){
            $meteor->city = $data->results[0]->components->city;
        }

        // Country
        if(!empty($data->results[0]->components->country)){
            $meteor->country = $data->results[0]->components->country;
        }

        // Flag
        if(!empty($data->results[0]->annotations->flag)){
            $meteor->flag = $data->results[0]->annotations->flag;
        }
    }

    // Energy
    if(!empty($meteor->mass)){
        // Calculate time
        // 100 km of distance, with a speed of 15 km/s
        // Convert km/s to m/s
        $v = 15 * 1000; // m/s

        // Convert g to kg
        $m = $meteor->mass / 1000; 

        // Calculate energy
        // 0.5 * m (kg) * v^2 (m/s)
        $Ec = 0.5 * $m * $v * $v; // J

        $meteor->energy_in_joules = round($Ec, 4); // kWh

        // Convert J to kWh
        $Ec = $Ec / 3600000;

        $meteor->energy_in_kWh = round($Ec, 4); // kWh
    }

    echo json_encode($meteor);