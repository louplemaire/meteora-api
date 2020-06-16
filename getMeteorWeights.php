<?php
    // Config
    include './includes/config.php';

    // Select years
    $query = $pdo->prepare('SELECT id, mass FROM meteorite_landings WHERE year = :year ORDER BY mass');
    $query->bindValue(':year', $_GET['year'], PDO::PARAM_INT);
    $query->execute();
    $meteorWeights = $query->fetchAll();

    echo json_encode($meteorWeights);