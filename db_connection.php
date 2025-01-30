<?php

function open_connection()
{
    $server_name = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'gestaosa';
    $conn = mysqli_connect($server_name, $username, $password, $dbname) or die("Connect failed: %s\n". mysqli_error($conn));
    return $conn;
}

function close_connection($conn)
{
    mysqli_close($conn);
}

?>