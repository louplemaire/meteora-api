<?php
    // Config
    include './includes/config.php';

    function calculate_median($arr):float {
        $count = count($arr); //total numbers in array
        $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            $median = (($low+$high)/2);
        }
        return $median;
    }

    // Select meteors
    $query = $pdo->prepare('SELECT mass FROM meteorite_landings WHERE year = :year ORDER BY mass');
    $query->bindValue(':year', $_GET['year'], PDO::PARAM_INT);
    $query->execute();
    $meteors = $query->fetchAll();
    $masses = array_map(function($m) {
        return $m->mass;
    }, $meteors);

    echo json_encode(calculate_median($masses));