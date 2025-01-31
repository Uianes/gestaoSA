<?php 
  include '../db_connection.php';
  $conn = open_connection();

  $numeroPatrimonio = !empty($_POST['numeroPatrimonio']) ? $_POST['numeroPatrimonio'] : null;
  $localizacao = !empty($_POST['localizacao']) ? $_POST['localizacao'] : null;
  $descricaoLocalizacao = !empty($_POST['descricaoLocalizacao']) ? $_POST['descricaoLocalizacao'] : null;
  $memorando = !empty($_POST['memorando']) ? $_POST['memorando'] : null;

  if (!$numeroPatrimonio || !$memorando || !$localizacao || !$descricaoLocalizacao) {
    echo '<script>alert("Número de patrimônio e memorando são obrigatórios para descarte.");</script>';
    close_connection($conn);
    header('Refresh: 0.5; URL=../index.php');
    exit;
  }

  try {
    $checkSql = "SELECT Status FROM patrimonio WHERE N_Patrimonio = ?";
    $result = mysqli_execute_query($conn, $checkSql, [$numeroPatrimonio]);
    $status = mysqli_fetch_assoc($result)['Status'];
    if ($status === 'Descarte') {
      echo '<script>alert("O patrimônio ' . $numeroPatrimonio . ' já foi descartado.");</script>';
      close_connection($conn);
      header('Refresh: 0.5; URL=../index.php');
      exit;
    }
  } catch (Exception $e) {
    echo '<script>alert("Erro ao verificar status: ' . $e->getMessage() . '");</script>';
    close_connection($conn);
    header('Refresh: 0.5; URL=../index.php');
    exit;
  }

  try {
    $sql = "UPDATE patrimonio
            SET Status = 'Descarte', Memorando = ?, Localizacao = ?, Descricao_Localizacao = ? WHERE N_Patrimonio = ?";
    mysqli_execute_query($conn, $sql, [$memorando, $localizacao, $descricaoLocalizacao, $numeroPatrimonio]);
    echo '<script>alert("O patrimônio ' . $numeroPatrimonio . ' foi descartado com sucesso!");</script>';
  } catch (Exception $e) {
    echo '<script>alert("Erro ao descartar patrimônio: ' . $e->getMessage() . '");</script>';
  }

  close_connection($conn);
  header('Refresh: 0.5; URL=../index.php');
?>