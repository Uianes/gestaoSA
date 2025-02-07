<?php
include '../db_connection.php';
$conn = open_connection();

$numeroPatrimonio = !empty($_POST['numeroPatrimonio']) ? $_POST['numeroPatrimonio'] : NULL;
$descricao = !empty($_POST['descricao']) ? $_POST['descricao'] : NULL;
$dataEntrada = !empty($_POST['dataEntrada']) ? $_POST['dataEntrada'] : NULL;
$localizacao = !empty($_POST['localizacao']) ? $_POST['localizacao'] : NULL;
$descricaoLocalizacao = !empty($_POST['descricaoLocalizacao']) ? $_POST['descricaoLocalizacao'] : NULL;
$status = !empty($_POST['status']) ? $_POST['status'] : NULL;
$memorando = !empty($_POST['memorando']) ? $_POST['memorando'] : NULL;

if (!$numeroPatrimonio || !$descricao || !$dataEntrada || !$localizacao || !$descricaoLocalizacao || !$status) {
  echo '<script>alert("Todos os campos são obrigatórios, exceto o memorando.");</script>';
  close_connection($conn);
  header('Refresh: 0.5; URL=../index.php');
  exit;
}

if ($status === 'Tombado') {
  $memorando = NULL;
}

if ($status === 'Descarte' && !$memorando) {
  echo '<script>alert("O memorando não pode ser nulo para descarte.");</script>';
  close_connection($conn);
  header('Refresh: 0.5; URL=../index.php');
  exit;
}

$sqlCheck = "SELECT COUNT(*) as total FROM patrimonio WHERE N_Patrimonio = ?";
$resultCheck = mysqli_execute_query($conn, $sqlCheck, [$numeroPatrimonio]);
$row = mysqli_fetch_assoc($resultCheck);

if ($row['total'] > 0) {
  echo '<script>alert("O patrimônio ' . $numeroPatrimonio . ' já foi cadastrado!");</script>';
  close_connection($conn);
  header('Refresh: 0.5; URL=../index.php');
  exit;
}

try {
  $sql = "INSERT INTO patrimonio (N_Patrimonio, Descricao, Data_Entrada, Localizacao, Descricao_Localizacao, Status, Memorando)
          VALUES (?, ?, ?, ?, ?, ?, ?)";
  mysqli_execute_query($conn, $sql, [
    $numeroPatrimonio,
    $descricao,
    $dataEntrada,
    $localizacao,
    $descricaoLocalizacao,
    $status,
    $memorando
  ]);
  echo '<script>alert("O patrimônio ' . $numeroPatrimonio . ' foi cadastrado com sucesso!");</script>';
} catch (Exception $e) {
  echo '<script>alert("Erro ao cadastrar patrimônio: ' . $e->getMessage() . '");</script>';
}

close_connection($conn);
header('Refresh: 0.5; URL=../index.php');
?>