<?php
// Definindo as variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestaosa";

// Criando a conexão com o banco de dados
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificando se a conexão foi bem-sucedida
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error()); // Se a conexão falhar, exibe uma mensagem de erro e encerra o script
}

// Criando a query SQL para deletar um registro da tabela Patrimonio
// O valor de 'numeroPatrimonio' é obtido do formulário enviado via método POST
$sql = "DELETE FROM `patrimonio` WHERE N_Patrimonio='" . $_POST['numeroPatrimonio_backup'] . "'";

// Executando a query SQL
if (mysqli_query($conn, $sql)) {
  header('Location: index.php'); // Se a query for executada com sucesso, redireciona o usuário para a página inicial
} else {
  echo "Error deleting record: " . mysqli_error($conn); // Se a query falhar, exibe uma mensagem de erro
}

// Fechando a conexão com o banco de dados
mysqli_close($conn);
?>