<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_local'])) {
  $_SESSION['message'] = "Sessão inválida.";
  $_SESSION['message_type'] = 'error';
  header('Location: ../index.php');
  exit;
}

if ($_SESSION['user_local'] !== 'SME' && $_SESSION['user_local'] !== $localizacao) {
  $_SESSION['message'] = "Você não tem permissão para cadastrar neste local.";
  $_SESSION['message_type'] = 'error';
  header('Location: ../index.php');
  exit;
}

$numeroPatrimonio = !empty($_POST['numeroPatrimonio']) ? $_POST['numeroPatrimonio'] : NULL;
$descricao = !empty($_POST['descricao']) ? $_POST['descricao'] : NULL;
$dataEntrada = !empty($_POST['dataEntrada']) ? $_POST['dataEntrada'] : NULL;
$localizacao = !empty($_POST['localizacao']) ? $_POST['localizacao'] : NULL;
$descricaoLocalizacao = !empty($_POST['descricaoLocalizacao']) ? $_POST['descricaoLocalizacao'] : NULL;
$status = !empty($_POST['status']) ? $_POST['status'] : NULL;
$memorando = !empty($_POST['memorando']) ? $_POST['memorando'] : NULL;

if (!$numeroPatrimonio || !$descricao || !$dataEntrada || !$localizacao || !$descricaoLocalizacao || !$status) {
  $_SESSION['message'] = "Todos os campos são obrigatórios, exceto o memorando.";
  $_SESSION['message_type'] = 'error';
  header('Location: ../index.php');
  exit;
}

if ($status === 'Tombado') {
  $memorando = NULL;
}

if ($status === 'Descarte' && !$memorando) {
  $_SESSION['message'] = "O memorando não pode ser nulo para descarte.";
  $_SESSION['message_type'] = 'error';
  header('Location: ../index.php');
  exit;
}

try {
  $conn = open_connection();
  $sqlCheck = "SELECT COUNT(*) as total FROM patrimonio WHERE N_Patrimonio = ?";
  $resultCheck = mysqli_execute_query($conn, $sqlCheck, [$numeroPatrimonio]);
  $row = mysqli_fetch_assoc($resultCheck);
  if ($row['total'] > 0) {
    $_SESSION['message'] = "O patrimônio $numeroPatrimonio já foi cadastrado!";
    $_SESSION['message_type'] = 'error';
    close_connection($conn);
    header('Location: ../index.php');
    exit;
  }
} catch (Exception $e) {
  $_SESSION['message'] = "Erro ao verificar patrimônio: " . $e->getMessage();
  $_SESSION['message_type'] = 'error';
  if (isset($conn)) {close_connection($conn);}
  header('Location: ../index.php');
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
  $_SESSION['message'] = "O patrimônio '$numeroPatrimonio' foi cadastrado com sucesso!";
  $_SESSION['message_type'] = 'success';
} catch (Exception $e) {
  $_SESSION['message'] = "Erro ao cadastrar patrimônio: " . $e->getMessage();
  $_SESSION['message_type'] = 'error';
}

if (isset($conn)) {close_connection($conn);}
header('Location: ../index.php');
?>