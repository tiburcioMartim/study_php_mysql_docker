<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'projeto';

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