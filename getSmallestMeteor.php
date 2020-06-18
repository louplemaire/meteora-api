<?php
    // Config
    include './includes/config.php';

    // Select meteors
    $query = $pdo->prepare('SELECT id, name, mass, year FROM meteorite_landings WHERE year = :year AND mass != 0 ORDER BY mass ASC LIMIT 1');
    $query->bindValue(':year', $_GET['year'], PDO::PARAM_INT);
    $query->execute();
    $meteors = $query->fetch();

    echo json_encode($meteors);