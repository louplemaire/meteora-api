<?php
    // Config
    include './includes/config.php';

    // Select meteors
    $query = $pdo->prepare('SELECT id, mass FROM meteorite_landings WHERE year = :year');
    $query->bindValue(':year', $_GET['year'], PDO::PARAM_INT);
    $query->execute();
    $meteors = $query->fetchAll();

    $mass = 0;
    $countMeteor = 0;

    // Calculate the total mass
    foreach ($meteors as $_meteor) {
        $mass += $_meteor->mass;
        $countMeteor += 1;
    }

    // Calculate the average mass
    $averageMass = $mass / $countMeteor;
    $averageMass = round($averageMass, 0);

    echo json_encode($averageMass);