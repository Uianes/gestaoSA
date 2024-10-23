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

// Criando a query SQL para inserir um novo registro na tabela 'patrimonio'
$sql = "INSERT INTO patrimonio (N_Patrimonio, Descricao, Data_Entrada, Localizacao, Status, Memorando)
VALUES ('". $_POST['numeroPatrimonio'] ."','". $_POST['descricao'] ."', '". $_POST['dataEntrada'] ."', '". $_POST['localizacao'] ."', '". $_POST['status'] ."', '".$_POST['memorando']."')";

// Executando a query SQL
if (mysqli_query($conn, $sql)) {
  echo "New record created successfully"; // Se a inserção for bem-sucedida, exibe uma mensagem de sucesso
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn); // Se houver um erro, exibe a query SQL e a mensagem de erro
}

// Fechando a conexão com o banco de dados
mysqli_close($conn);
?>