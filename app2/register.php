<?php
// declare(strict_types=1);

require_once __DIR__ . 'connection.php';

// session_start();

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Defaults para preencher inputs
$old = $_SESSION['old'] ?? ['nome' => '', 'email' => ''];
$flash = $_SESSION['flash'] ?? null;

// limpa sessão de flash/old após usar (PRG)
unset($_SESSION['old'], $_SESSION['flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim((string) filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW) ?? '');
    $email = trim((string) filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW) ?? '');
    $senha = (string) (filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW) ?? '');

    // guarda o que o usuário digitou (menos senha) para reexibir se der erro
    $_SESSION['old'] = ['nome' => $nome, 'email' => $email];

    // Validações (entrada)
    $errors = [];

    if ($nome === '' || mb_strlen($nome) < 2) {
        $errors[] = 'Informe um nome válido (mínimo 2 caracteres).';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Informe um e-mail válido.';
    }

    if (mb_strlen($senha) < 4) {
        $errors[] = 'A senha deve ter pelo menos 4 caracteres.';
    }

    if ($errors) {
        $_SESSION['flash'] = ['type' => 'error', 'messages' => $errors];
        header('Location: cadastrar.php');
        exit;
    }

    try {
        // (Opcional mas muito comum) checar se email já existe
        $check = $conn->prepare('SELECT 1 FROM usuarios WHERE email = ? LIMIT 1');
        $check->bind_param('s', $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $_SESSION['flash'] = ['type' => 'error', 'messages' => ['Este e-mail já está cadastrado.']];
            header('Location: cadastrar.php');
            exit;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $nome, $email, $senhaHash);
        $stmt->execute();

        $_SESSION['flash'] = ['type' => 'success', 'messages' => ['Usuário cadastrado com sucesso!']];
        // Limpa old após sucesso
        unset($_SESSION['old']);

        header('Location: index.php');
        exit;

    } catch (mysqli_sql_exception $e) {
        error_log('[CADASTRAR] ' . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'error', 'messages' => ['Erro ao cadastrar. Tente novamente.']];
        header('Location: cadastrar.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Cadastrar usuários</h2>
    <a href="index.php">Listar usuários</a><br><br>

    <?php if ($flash): ?>
        <?php if ($flash['type'] === 'success'): ?>
            <p style="color:#086;"><?= e($flash['messages'][0] ?? ''); ?></p>
        <?php else: ?>
            <div style="color:#f00;">
                <?php foreach (($flash['messages'] ?? []) as $msg): ?>
                    <p><?= e((string)$msg); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <form action="cadastrar.php" method="post" autocomplete="on" novalidate>
        <label for="nome">Nome: </label>
        <input id="nome" type="text" name="nome" value="<?= e((string)($old['nome'] ?? '')); ?>" required><br><br>

        <label for="email">E-mail: </label>
        <input id="email" type="email" name="email" value="<?= e((string)($old['email'] ?? '')); ?>" required><br><br>

        <label for="senha">Senha: </label>
        <input id="senha" type="password" name="senha" required minlength="4"><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>