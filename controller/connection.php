<?php 

function connect()
{
    //Kết nối tới database
    $connect = mysqli_connect('localhost', 'root', 'Vak2272001', 'forum-x') or die('Không thể kết nối tới database');
    mysqli_set_charset($connect, 'UTF8');
    if ($connect === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    return $connect;
}
