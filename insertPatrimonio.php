<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestaosa";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO `patrimonio` (N_Patrimonio, Descricao, Data_Entrada, Localizacao, Status, Memorando)
VALUES ('". $_POST['numeroPatrimonio'] ."','". $_POST['descricao'] ."', '". $_POST['dataEntrada'] ."', '". $_POST['localizacao'] ."', '". $_POST['status'] ."', '".$_POST['memorando']."')";

if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>