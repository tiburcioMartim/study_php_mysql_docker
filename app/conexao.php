<?php
    require_once __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $hostname = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $database = $_ENV['DB_BANCO'];

    try {
        $conn = new mysqli($hostname, $username, $password, $database);
        $conn->set_charset("utf8mb4");
        return $conn;
        // echo "Conectado com sucesso!";

    } catch (mysqli_sql_exception $e) {
        error_log($e->getMessage());
        echo "Falha ao conectar." . "<pre>$e</pre>";
        exit();
    }
?>