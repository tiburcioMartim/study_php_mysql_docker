<?php
// require_once __DIR__ . 'bootstrap.php';
require_once("bootstrap.php");

// Ativa o modo tipagem estrita no PHP para este documento.
//Ele obriga o PHP a respeitar exatamente os tipo declarados nas funções.
// declare(strict_types=1);

// conexao.php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * Em produção, você NÃO deve deixar credenciais hardcoded.
 * Use variáveis de ambiente.
 *
 * Exemplo (Linux/Docker):
 * DB_HOST=localhost
 * DB_USER=root
 * DB_PASS=secret
 * DB_NAME=projeto
 * DB_PORT=3306
 * APP_DEBUG=0
 */

$APP_DEBUG = (bool) (getenv('APP_DEBUG') ?: false);

$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'projeto';
$DB_PORT = (int) (getenv('DB_PORT') ?: 3306);

try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('[DB] ' . $e->getMessage());

    http_response_code(500);

    if ($APP_DEBUG) {
        echo "<h1>Erro de conexão</h1><pre>" . htmlspecialchars((string)$e, ENT_QUOTES, 'UTF-8') . "</pre>";
    } else {
        echo "<h1>Erro interno</h1><p>Tente novamente mais tarde.</p>";
    }
    exit;
}