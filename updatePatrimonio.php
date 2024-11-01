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

if ($_POST['status'] === 'tombado') {
  $sql = "UPDATE `patrimonio` SET Descricao='" . $_POST['descricao'] . "', Data_Entrada='" . $_POST['dataEntrada'] . "', Localizacao='" . $_POST['localizacao'] . "', Status='" . $_POST['status'] . "'
WHERE N_Patrimonio='" . $_POST['numeroPatrimonio'] . "'";
} elseif ($_POST['status'] === 'descarte') {
  $sql = "UPDATE `patrimonio` SET Descricao='" . $_POST['descricao'] . "', Data_Entrada='" . $_POST['dataEntrada'] . "', Localizacao='" . $_POST['localizacao'] . "', Status='" . $_POST['status'] . "', Memorando='" . $_POST['memorando'] . "'
  WHERE N_Patrimonio='" . $_POST['numeroPatrimonio'] . "'";
}

if (mysqli_query($conn, $sql)) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
