<?php 
include '../db_connection.php';
$conn = open_connection();

$idPatrimonioExcluir = !empty($_POST['idPatrimonioExcluir']) ? $_POST['idPatrimonioExcluir'] : NULL;

if (!$idPatrimonioExcluir) {
  echo '<script>alert("O campo Nº Patrimônio é obrigatório.");</script>';
  close_connection($conn);
  header('Refresh: 0.5; URL=../index.php');
  exit;
}

$sqlCheck = "SELECT COUNT(*) as total FROM patrimonio WHERE N_Patrimonio = ?";
$resultCheck = mysqli_execute_query($conn, $sqlCheck, [$idPatrimonioExcluir]);
$row = mysqli_fetch_assoc($resultCheck);

if ($row['total'] == 0) {
  echo '<script>alert("O patrimônio ' . $idPatrimonioExcluir . ' não foi encontrado!");</script>';
  close_connection($conn);
  header('Refresh: 0.5; URL=../index.php');
  exit;
}

try {
  $sql = "DELETE FROM patrimonio WHERE N_Patrimonio = ?";
  mysqli_execute_query($conn, $sql, [$idPatrimonioExcluir]);
  echo '<script>alert("O patrimônio ' . $idPatrimonioExcluir . ' foi excluído com sucesso!");</script>';
} catch (Exception $e) {
  echo '<script>alert("Erro ao excluir patrimônio: ' . $e->getMessage() . '");</script>';
}

close_connection($conn);
header('Refresh: 0.5; URL=../index.php');
?>