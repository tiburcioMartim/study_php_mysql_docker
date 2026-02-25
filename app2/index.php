<?php
// declare(strict_types=1);

// require_once __DIR__ . 'connection.php';
require_once ("connection.php");

// session_start();

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$usuarios = [];

try {
    $stmt = $conn->prepare('SELECT id, nome, email FROM usuarios ORDER BY id DESC');
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result) {
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
    }
} catch (mysqli_sql_exception $e) {
    error_log('[LISTAR] ' . $e->getMessage());
    $flash = ['type' => 'error', 'messages' => ['Erro ao carregar usuários.']];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Listar usuários</h2>
    <a href="cadastrar.php">Cadastrar</a>
    <br><br>

    <?php if ($flash): ?>
        <div style="color:<?= $flash['type'] === 'success' ? '#086' : '#f00'; ?>">
            <?php foreach (($flash['messages'] ?? []) as $msg): ?>
                <p><?= e((string)$msg); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="list_users">
        <?php if (!$usuarios): ?>
            <p>Nenhum usuário encontrado.</p>
        <?php else: ?>
            <?php foreach ($usuarios as $u): ?>
                <p>
                    <strong>ID:</strong> <?= (int)$u['id']; ?>
                    <strong><br>Nome:</strong> <?= e((string)$u['nome']); ?>
                    <strong><br>Email:</strong> <?= e((string)$u['email']); ?>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>