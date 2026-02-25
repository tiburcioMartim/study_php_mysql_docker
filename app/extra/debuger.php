<?php
echo "<h2 style='color: red;'>=====[ DEBUGANDO ]=====</h2> <pre>";
echo var_dump($nome);
echo "</pre>";
echo "<h2 style='color: red;'>========================</h2><br>";


// echo var_dump($stmt);
// object(mysqli_stmt)#2 (10) {
//   ["affected_rows"]=>   //Quantas linhas de registros, tuplas, foram afetadas
//   int(1)
//   ["insert_id"]=>   //Número do id adicionado ao registro, é automático porque é AUTO_INCREMENT
//   int(20)
//   ["num_rows"]=>    //Número de registros retornados quando é solicitado um SELECT
//   int(0)
//   ["param_count"]=> //Quantos parâmetros estão sendo bindados, nesse caso 3: name, user, password
//   int(3)
//   ["field_count"]=> //Número de colunas retornadas, nosso caso 3: nome, usuario, senha
//   int(0)
//   ["errno"]=>   //Código de erro, 0 significa: nenhum erro
//   int(0)
//   ["error"]=>   //Mensagem de erro, "" significa: sem mensagem
//   string(0) ""
//   ["error_list"]=> //Lista de erros detalhados
//   array(0) {
//   }
//   ["sqlstate"]=>    //Código padrão do SQL, "00000" significa: sucesso
//   string(5) "00000"
//   ["id"]=>
//   int(1)
// }
?>




