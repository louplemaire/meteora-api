<?php
    // Config
    include './includes/config.php';

    // Select meteors
    $query = $pdo->prepare('SELECT id FROM meteorite_landings WHERE year = :year');
    $query->bindValue(':year', $_GET['year'], PDO::PARAM_INT);
    $query->execute();

    echo $query->rowCount();