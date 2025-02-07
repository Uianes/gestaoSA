<?php 
include '../db_connection.php';
$conn = open_connection();


close_connection($conn);
header('Refresh: 0.5; URL=../index.php');
?>