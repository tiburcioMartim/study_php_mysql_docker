<?php  
    require_once("conexao.php"); 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listar Usuários</title>
    </head>
    <body>
        <h2>Listar usuários</h2>
        <a href="cadastrar.php">Cadastrar</a>

        <?php
            try {
                $query_user = "SELECT id, nome, email FROM usuarios ORDER BY ID DESC";  //Comando em SQL
                $stmt = $conn->prepare($query_user);    //Cria instancia onde $stmt tem acesso ao banco com o comando SQL revisado pelo método prepare()

                if (!$stmt) {
                    die("<p style='color:#f00;'>Erro no prepare: " . htmlspecialchars($conn->error) . "</p>");
                    }
                if (!$stmt->execute()) {
                    die("<p style='color:#f00;'>Erro no prepare: " . htmlspecialchars($stmt->error) . "</p>");
                }

                $stmt->bind_result($id, $nome, $email);

                while ($stmt->fetch()) {
                    echo "<p>"          . 
                            "ID: "      . htmlspecialchars((int)$id, ENT_QUOTES, 'UTF-8')         . 
                            "Nome: "    . htmlspecialchars($nome['nome'], ENT_QUOTES, 'UTF-8')    . 
                            "Email: "   . htmlspecialchars($email['email'], ENT_QUOTES, 'UTF-8')  .                    
                         "</p>";
                }
                
            } catch (mysqli_sql_exception $e) {
                error_log($e->getMessage());
                echo "Falhou  ;(";
            }

        ?>
    </body>
</html>