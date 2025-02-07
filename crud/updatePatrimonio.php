<?php 
include '../db_connection.php';
$conn = open_connection();

$numeroPatrimonio = !empty($_POST['numeroPatrimonio']) ? $_POST['numeroPatrimonio'] : NULL;
$descricao = !empty($_POST['descricao']) ? $_POST['descricao'] : NULL;
$dataEntrada = !empty($_POST['dataEntrada']) ? $_POST['dataEntrada'] : NULL;
$localizacao = !empty($_POST['localizacao']) ? $_POST['localizacao'] : NULL;
$descricaoLocalizacao = !empty($_POST['DescricaoLocalizacaoEditar']) ? $_POST['DescricaoLocalizacaoEditar'] : NULL;

if (!$numeroPatrimonio || !$descricao || !$dataEntrada || !$localizacao || !$descricaoLocalizacao) {
  echo '<script>alert("Todos os campos são obrigatórios.");</script>';
  close_connection($conn);
  header('Refresh: 0.5; URL=../index.php');
  exit;
}

$sqlCheck = "SELECT COUNT(*) as total FROM patrimonio WHERE N_Patrimonio = ?";
$resultCheck = mysqli_execute_query($conn, $sqlCheck, [$numeroPatrimonio]);
$row = mysqli_fetch_assoc($resultCheck);

if ($row['total'] == 0) {
  echo '<script>alert("O patrimônio ' . $numeroPatrimonio . ' não foi encontrado!");</script>';
  close_connection($conn);
  header('Refresh: 0.5; URL=../index.php');
  exit;
}

try {
  $sql = "UPDATE patrimonio SET Descricao = ?, Data_Entrada = ?, Localizacao = ?, Descricao_Localizacao = ? WHERE N_Patrimonio = ?";
  mysqli_execute_query($conn, $sql, [
    $descricao,
    $dataEntrada,
    $localizacao,
    $descricaoLocalizacao,
    $numeroPatrimonio
  ]);
  echo '<script>alert("O patrimônio ' . $numeroPatrimonio . ' foi atualizado com sucesso!");</script>';
} catch (Exception $e) {
  echo '<script>alert("Erro ao atualizar patrimônio: ' . $e->getMessage() . '");</script>';
}

close_connection($conn);
header('Refresh: 0.5; URL=../index.php');
?>