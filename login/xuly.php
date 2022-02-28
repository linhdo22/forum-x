<?php
require_once __DIR__ . "/../controller/connection.php";
//Xử lý đăng nhập
if (isset($_POST['login'])) {
    //Kết nối tới database
    $connect = connect();

    //Lấy dữ liệu nhập vào
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);

    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if (!$username || !$password) {
        echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }

    //Kiểm tra tên đăng nhập có tồn tại không
    $query = "SELECT * FROM member WHERE username='$username'";

    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));

    //Lấy mật khẩu trong database ra
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //So sánh 2 mật khẩu có trùng khớp hay không
    if ($password != $row['password']) {
        echo "Mật khẩu không đúng. Vui lòng nhập lại. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
    //Lưu tên đăng nhập
    unset($row['password']);
    $_SESSION['user'] = $row;
    $connect->close();
    header('Location: ../home/home.php');
    die();
}
