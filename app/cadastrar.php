<?php
    require_once("conexao.php");            //Solicita o arquivo conexao.php e insere ele aqui apenas uma vez
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);    //Permite o lançamento de exceptions Flag1: Permite captura do erro, Flag2: Transforma o erro em mysqli_sql_exception
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

    <?php
        try {
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);    //Não é uma boa prática sanitizar na entrada

            if (!empty($dados['cad_user'])) { // Enquanto o botão cadastrar não for apertado, if será FALSE
                $nome = trim($dados['nome'] ?? '');
                $email = trim($dados['email'] ?? '');
                $senha = $dados['senha'] ?? '';
                $senha_cript = password_hash($senha, PASSWORD_DEFAULT); //Converte a senha em um hash, uma senha criptografada

                $query_user = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)"; //Comando para enviar ao banco de dados
                $stmt = $conn->prepare($query_user);    //Cria uma instância que faz uma preparação no comando SQL, para evitar SQL Injection

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
                        // echo "<p style='color: #f00;'>Código de erro: " . $stmt->errno . "</P>"; // Para debugar
                        // echo "<p style='color: #f00;'>Mensagem de erro: " . $stmt->error . "</P>"; // Para debugar

                    }
                }
            }

        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage());
            echo "<h2>Erro:</h2> " . "<br><pre>$e</pre>";
        }  
    ?>

    <form action="" method="post">
        <label for="nome">Nome: </label>
        <input type="text" name="nome" value="<?= $nome ?? ''; ?>" required><br><br>

        <label for="email">E-mail: </label>
        <input type="email" name="email" value="<?= $email ?? ''; ?>" required><br><br>

        <label for="senha">Senha: </label>
        <input type="password" name="senha" required><br><br>     
        
        <button type="submit" name="cad_user" value="1">Cadastrar</button>
    </form>
</body>
</html>