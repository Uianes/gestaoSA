<?php
include './db_connection.php';

if (!isset($_POST['locais']) || empty($_POST['locais'])) {
    echo "<script>alert('Nenhuma escola selecionada.'); window.close();</script>";
    exit;
}

$conn = open_connection();
$schools = $_POST['locais'];
$date = date('d/m/Y H:i:s');

close_connection($conn);
?>