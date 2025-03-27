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
  $_SESSION['message'] = "Você não tem permissão para descartar este patrimonio.";
  $_SESSION['message_type'] = 'error';
  header('Location: ../index.php');
  exit;
}

$numeroPatrimonio = !empty($_POST['numeroPatrimonio']) ? $_POST['numeroPatrimonio'] : null;
$localizacao = !empty($_POST['localizacao']) ? $_POST['localizacao'] : null;
$descricaoLocalizacao = !empty($_POST['descricaoLocalizacao']) ? $_POST['descricaoLocalizacao'] : null;
$memorando = !empty($_POST['memorando']) ? $_POST['memorando'] : null;

if (!$numeroPatrimonio || !$memorando || !$localizacao || !$descricaoLocalizacao) {
  $_SESSION['message'] = "Número de patrimônio, localização, descrição da localização e memorando são obrigatórios para descarte.";
  $_SESSION['message_type'] = 'error';
  header('Location: ../index.php');
  exit;
}


try {
  $conn = open_connection();
  $checkSql = "SELECT Status FROM patrimonio WHERE N_Patrimonio = ?";
  $result = mysqli_execute_query($conn, $checkSql, [$numeroPatrimonio]);
  $status = mysqli_fetch_assoc($result)['Status'];
  if ($status === 'Descarte') {
    $_SESSION['message'] = "O patrimônio $numeroPatrimonio já foi descartado.";
    $_SESSION['message_type'] = 'error';
    close_connection($conn);
    header('Location: ../index.php');
    exit;
  }
} catch (Exception $e) {
  $_SESSION['message'] = "Erro ao verificar status: " . $e->getMessage();
  $_SESSION['message_type'] = 'error';
  if (isset($conn)) {close_connection($conn);}
  header('Location: ../index.php');
  exit;
}

try {
  $sql = "UPDATE patrimonio
          SET Status = 'Descarte', Memorando = ?, Localizacao = ?, Descricao_Localizacao = ? WHERE N_Patrimonio = ?";
  mysqli_execute_query($conn, $sql, [$memorando, $localizacao, $descricaoLocalizacao, $numeroPatrimonio]);
  $_SESSION['message'] = "O patrimônio '$numeroPatrimonio' foi descartado com sucesso!";
  $_SESSION['message_type'] = 'success';
} catch (Exception $e) {
  $_SESSION['message'] = "Erro ao descartar patrimônio: " . $e->getMessage();
  $_SESSION['message_type'] = 'error';
}

if (isset($conn)) {close_connection($conn);}
header('Location: ../index.php');
?>
