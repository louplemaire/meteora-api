<?php
    header("Access-Control-Allow-Origin: *");

    if($_SERVER['HTTP_HOST'] === 'localhost:8888'){
        // Errors
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Database local
        define('DB_HOST', 'localhost');
        define('DB_PORT', '8889');
        define('DB_NAME', 'hetic_meteora');
        define('DB_USER', 'root');
        define('DB_PASS', 'root');
    } else{
        // Database online
        $env = file_get_contents('./.env');
        $env = parse_ini_string($env);

        define('DB_HOST', $env[DB_HOST]);
        define('DB_PORT', $env[DB_PORT]);
        define('DB_NAME', $env[DB_NAME]);
        define('DB_USER', $env[DB_USER]);
        define('DB_PASS', $env[DB_PASS]);
    }

    // Database
    $pdo = new PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Return errors
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // Return object tab

    // OpenCage API
    define('OPEN_CAGE_API_KEY', '4049b26c11ac413f97cc99f64ac0be15');