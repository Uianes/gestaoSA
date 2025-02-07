<?php
include './db_connection.php';

if (!isset($_POST['locais']) || empty($_POST['locais'])) {
    echo "<div class='alert alert-danger'>Nenhuma escola selecionada.</div>";
    header('Refresh: 0.5; URL=./index.php');
    exit;
}

$conn = open_connection();
$schools = $_POST['locais'];
$date = date('d/m/Y H:i:s');

close_connection($conn);
?>