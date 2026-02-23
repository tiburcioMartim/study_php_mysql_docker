<?php require_once("conexao.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto</title>
</head>

<body>

    <h2>Listar usuários</h2>
    <a href="cadastrar.php">Cadastrar</a>

    <?php
    $query_usuarios = "SELECT id, nome, email FROM usuarios ORDER BY id DESC";

    $stmt = $conn->prepare($query_usuarios);

    if (!$stmt) {
        die("<p style='color:#f00;'>Erro no prepare: " . htmlspecialchars($conn->error) . "</p>");
    }

    if (!$stmt->execute()) {
        die("<p style='color:#f00;'>Erro no execute: " . htmlspecialchars($stmt->error) . "</p>");
    }

    // ✅ Se tiver mysqlnd, usa get_result()
    if (method_exists($stmt, 'get_result')) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<p>ID: " . (int)$row['id']
                . " - Nome: " . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8')
                . " - Email: " . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8')
                . "</p>";
        }
    } else {
        // ✅ Fallback (funciona em qualquer mysqli)
        $stmt->bind_result($id, $nome, $email);

        while ($stmt->fetch()) {
            echo "<p>ID: " . (int)$id .
                " - Nome: "  . htmlspecialchars($nome['nome'], ENT_QUOTES, 'UTF-8') .
                " - Email: " . htmlspecialchars($email['email'], ENT_QUOTES, 'UTF-8') . "</p>";
        }
    }

    $stmt->close();
    ?>

</body>

</html>