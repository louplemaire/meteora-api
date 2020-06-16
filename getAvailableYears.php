<?php
    // Config
    include './includes/config.php';

    // Select years
    $query = $pdo->query('SELECT year, COUNT(year) as meteorsCount FROM meteorite_landings GROUP BY year');
    $years = $query->fetchAll();

    echo json_encode($years);