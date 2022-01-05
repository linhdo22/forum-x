<?php

//Xử lý đăng nhập
if (isset($_POST['login'])) {
    //Kết nối tới database
    $connect = mysqli_connect('localhost', 'root', 'Vak2272001', 'forum-x') or die('Không thể kết nối tới database');
    mysqli_set_charset($connect, 'UTF8');
    if ($connect === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

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

    if (!$result) {
        echo "Tên đăng nhập hoặc mật khẩu không đúng!";
    } else {
        echo "Đăng nhập thành công!";
    }

    //Lấy mật khẩu trong database ra
    $row = mysqli_fetch_array($result);

    //So sánh 2 mật khẩu có trùng khớp hay không
    if ($password != $row['password']) {
        echo "Mật khẩu không đúng. Vui lòng nhập lại. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
    //Lưu tên đăng nhập
    $_SESSION['user'] = $row;
    $connect->close();
    header('Location: ../home/home.php');
    die();
}
