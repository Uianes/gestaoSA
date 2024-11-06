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

  $sql = "UPDATE `patrimonio` SET Descricao='" . $_POST['descricao'] . "', Data_Entrada='" . $_POST['dataEntrada'] . "', Localizacao='" . $_POST['localizacao'] . "'
WHERE N_Patrimonio='" . $_POST['numeroPatrimonio_backup'] . "'";

if (mysqli_query($conn, $sql)) {
  header('Location: index.php');
} else {
  echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>