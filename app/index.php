<?php require_once("conexao.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
   
    $result = $stmt->get_result();
    echo "<div class='list_users'>";
    while ($row = $result->fetch_assoc()) {
        echo "<p><br><b>ID:</b> " . (int)$row['id']
            . "<br><b>Nome:</b> " . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8')
            . "<br><b>Email:</b> " . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8')
            . "</p>";
    }
    echo "<div>";    

    $stmt->close();
    ?>

</body>

</html>