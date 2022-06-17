<?php
require_once __DIR__ . '/env.php';


function connect()
{
    //Kết nối tới database
    $connect = mysqli_connect($_ENV['mysql-host'], $_ENV['mysql-username'], $_ENV['mysql-password'], $_ENV['mysql-db']) or die('Không thể kết nối tới database');
    mysqli_set_charset($connect, 'UTF8');
    if ($connect === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    } 
    return $connect;
}
