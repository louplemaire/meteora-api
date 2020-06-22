<?php
    // Config
    include './includes/config.php';

    // Select meteors
    $query = $pdo->prepare('SELECT m.id, m.name, m.recclass, m.mass, m.found, m.year, m.reclat, m.reclong, l.city, l.country, l.flag, l.id as localisationId
                            FROM meteorite_landings as m
                            LEFT OUTER JOIN localisations as l
                                ON m.id = l.id_meteor
                            WHERE m.id = :id
                            ');
    $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $query->execute();
    $meteor = $query->fetch();

    // Fetch OpenCage API
    if(empty($meteor->localisationId) && !empty($meteor->reclat) && !empty($meteor->reclong)){
        $url = 'https://api.opencagedata.com/geocode/v1/json?q='.$meteor->reclat.'+'.$meteor->reclong.'&key='.OPEN_CAGE_API_KEY;
        $data = @file_get_contents($url);

        if ($data !== false) {
            $data = json_decode($data);

        // Save in database
            $prepare = $pdo->prepare('
                INSERT INTO
                    localisations (id_meteor, city, country, flag)
                VALUES
                    (:id_meteor, :city, :country, :flag)
            ');
            $prepare->bindValue(':id_meteor', $meteor->id, PDO::PARAM_INT);
            $prepare->bindValue(':city', $data->results[0]->components->city ?: null);
            $prepare->bindValue(':country', $data->results[0]->components->country ?: null);
            $prepare->bindValue(':flag', $data->results[0]->annotations->flag ?: null);
            $prepare->execute();

            $meteor->city = $data->results[0]->components->city ?: '';
            $meteor->country = $data->results[0]->components->country ?: '';
            $meteor->flag = $data->results[0]->annotations->flag ?: '';
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
            $meteor->mass_comparison = '2 AA batteries 🔋';
        } else if(50 <=$meteor->mass && $meteor->mass < 100){
            $meteor->mass_comparison = 'Pack of 54 cards 🃏';
        } else if(100 <= $meteor->mass && $meteor->mass < 150){
            $meteor->mass_comparison = 'A Baseball ⚾️';
        } else if(150 <= $meteor->mass && $meteor->mass < 200){
            $meteor->mass_comparison = 'A Hamster 🐹';
        } else if(200 <= $meteor->mass && $meteor->mass < 250){
            $meteor->mass_comparison = 'Can of Soup Cambell’s 🥣';
        } else if(250 <= $meteor->mass && $meteor->mass < 500){
            $meteor->mass_comparison = 'Human Heart ♥️';
        } else if(500 <= $meteor->mass && $meteor->mass < 750){
            $meteor->mass_comparison = 'A football ⚽️';
        } else if(750 <= $meteor->mass && $meteor->mass < 1000){
            $meteor->mass_comparison = 'A basketball 🏀';
        } else if(1000 <= $meteor->mass && $meteor->mass < 1500){
            $meteor->mass_comparison = 'A liter of water 🚰';
        } else if(1500 <= $meteor->mass && $meteor->mass < 2000){
            $meteor->mass_comparison = 'A chihuahua 🐶';
        } else if(2000 <= $meteor->mass && $meteor->mass < 2500){
            $meteor->mass_comparison = '2 carpfishes 🐟';
        } else if(2500 <= $meteor->mass && $meteor->mass < 3000){
            $meteor->mass_comparison = 'A brick 🧱';
        } else if(3000 <= $meteor->mass && $meteor->mass < 3500){
            $meteor->mass_comparison = 'A guitar 🎸';
        } else if(3500 <= $meteor->mass && $meteor->mass < 4000){
            $meteor->mass_comparison = 'A cat 🐱';
        } else if(4000 <= $meteor->mass){
            $meteor->mass_comparison = 'Woah that’s big ☄️';
        }

        // Energy comparisons
        if($meteor->energy_in_kWh < 0.2){
            $meteor->energy_comparison = 'Insignificant 😴';
        } else if(0.2 <= $meteor->energy_in_kWh && $meteor->energy_in_kWh < 0.8){
            $mult = $meteor->energy_in_kWh / 0.27;

            $meteor->energy_comparison = $mult > 1 ? 'The nutritional value of '.round($mult, 1).' meals 🍝' : 'The nutritional value of '.round($mult, 1).' meal 🍝';
        } else if(0.8 <= $meteor->energy_in_kWh && $meteor->energy_in_kWh < 270){
            $mult = $meteor->energy_in_kWh / 1;

            $meteor->energy_comparison = $mult > 1 ? 'The explosion of '.round($mult, 1).' shells 💣' : 'The explosion of '.round($mult, 1).' shell 💣';
        } else if(270 <= $meteor->energy_in_kWh){
            $mult = $meteor->energy_in_kWh / 277;

            $meteor->energy_comparison = $mult > 1 ? round($mult, 1).' lightnings during a thunderstorm ⚡️' : round($mult, 1).' lightning during a thunderstorm ⚡️';
        }
    }

    echo json_encode($meteor);