<?php
    // Config
    include './includes/config.php';

    // Select meteors
    $query = $pdo->prepare('SELECT id, name, recclass, mass, found, year, reclat, reclong FROM meteorite_landings WHERE id = :id');
    $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $query->execute();
    $meteors = $query->fetchAll();

    echo json_encode($meteors);