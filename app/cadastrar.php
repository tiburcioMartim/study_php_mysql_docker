<?php 
require_once("conexao.php"); 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastrar Usuário</title>
</head>

<body>
    <h2>Cadastrar Usuário</h2>
    <a href="index.php">Listar</a><br><br>

    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);  // Estrutura da função | filter_input_array(tipo_de_entrada, tipo_de_filtro);

        if (!empty($dados['CadUsuario'])) {
            $nome = trim($dados['nome'] ?? '');
            $email = trim($dados['email'] ?? '');
            $senha = $dados['senha'] ?? '';

            $senha_cript = password_hash($senha, PASSWORD_DEFAULT);

            $query_usuario = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";

            $stmt = $conn->prepare($query_usuario);

            if ($stmt) {
                $stmt->bind_param("sss", $nome, $email, $senha_cript);

                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        echo "<p style='color: #086;'>Usuário cadastrado com sucesso!</p>";
                        unset($dados);
                    } else {
                        echo "<p style='color: #f00;'>Usuário não cadastrado com sucesso!</p>";
                    }
                } else {
                    echo "<p style='color: #f00;'>Usuário não cadastrado com sucesso!</p>"; // Erro ao executar
                    // echo "<p style='color: #f00;'>Erro execute: " . $stmt->error . "</P>"; // Para debugar
                }

                $stmt->close();
            } else {
                echo "<p style='color: #f00;'>Usuário não cadastrado com sucesso!</p>"; // Erro ao preparar
                // echo "<p style='color: #f00;'>Erro prepare: " . $conn->error . "</P>"; // Para debugar
            }
        }
    ?>

    <form action="" method="post">

        <label for="nome">Nome: </label>
        <input type="text" name="nome" id="nome_id" placeholder="Nome completo"
        value="<?php echo htmlspecialchars($dados['nome'] ?? "", ENT_QUOTES, 'UTF-8'); ?>" required> <br><br>

        <label for="email">E-mail: </label>
        <input type="email" name="email" id="email_id" placeholder="Melhor e-mail do usuário"
        value="<?php echo htmlspecialchars($dados['email'] ?? "", ENT_QUOTES, 'UTF-8');?>" required> <br><br>

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha_id" placeholder="Senha do usuário"
        value="<?php echo htmlspecialchars($dados['senha'] ?? "", ENT_QUOTES, 'UTF-8');?>" required> <br><br>

        <input type="submit" value="Cadastrar" name="CadUsuario">

    </form>

</body>

</html>