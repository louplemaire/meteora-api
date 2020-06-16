<?php
    // Config
    include './includes/config.php';

    // Select meteors
    $query = $pdo->prepare('SELECT id, year FROM meteorite_landings WHERE year = :year');
    $query->bindValue(':year', $_GET['year'], PDO::PARAM_INT);
    $query->execute();
    $meteors = $query->fetchAll();

    echo count($meteors);