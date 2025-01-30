<?php 
  include '../db_connection.php';
  $conn = open_connection();


  
  close_connection($conn);
  header('Location: ../index.php');
?>