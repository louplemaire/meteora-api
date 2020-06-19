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

    // Mass and energy comparisons
    if(!empty($meteor->mass)){
        // Calculate speed
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

        // Mass comparisons
        if(1 <= $meteor->mass && $meteor->mass < 50){
            $meteor->mass_comparison = "2 AA batteries";
        } else if(50 <=$meteor->mass && $meteor->mass < 100){
            $meteor->mass_comparison = "Pack of 54 cards";
        } else if(100 <= $meteor->mass && $meteor->mass < 150){
            $meteor->mass_comparison = "A Baseball";
        } else if(150 <= $meteor->mass && $meteor->mass < 200){
            $meteor->mass_comparison = "A Hamster";
        } else if(200 <= $meteor->mass && $meteor->mass < 250){
            $meteor->mass_comparison = "Can of Soup Cambell’s";
        } else if(250 <= $meteor->mass && $meteor->mass < 500){
            $meteor->mass_comparison = "Human Heart";
        } else if(500 <= $meteor->mass && $meteor->mass < 750){
            $meteor->mass_comparison = "A football";
        } else if(750 <= $meteor->mass && $meteor->mass < 1000){
            $meteor->mass_comparison = "A basketball";
        } else if(1000 <= $meteor->mass && $meteor->mass < 1500){
            $meteor->mass_comparison = "A liter of water";
        } else if(1500 <= $meteor->mass && $meteor->mass < 2000){
            $meteor->mass_comparison = "A chihuahua";
        } else if(2000 <= $meteor->mass && $meteor->mass < 2500){
            $meteor->mass_comparison = "2 carpfishes";
        } else if(2500 <= $meteor->mass && $meteor->mass < 3000){
            $meteor->mass_comparison = "A brick";
        } else if(3000 <= $meteor->mass && $meteor->mass < 3500){
            $meteor->mass_comparison = "A guitar";
        } else if(3500 <= $meteor->mass && $meteor->mass < 4000){
            $meteor->mass_comparison = "A cat";
        } else if(4000 <= $meteor->mass){
            $meteor->mass_comparison = "Woah that’s big";
        }
    }

    echo json_encode($meteor);