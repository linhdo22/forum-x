<?php
if (!isset($_SESSION)) {
    session_start();
} ?>
<script src="../common/js/jquery-3.6.0.min.js"></script>
<link rel='stylesheet' href='../common/css/header.css'>
<script src='../common/js/header.js'></script>
<script src="../assets/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
<link rel='stylesheet' href='../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css'>
<div class="header">
    <div class="nav">
        <div class="navLeft">
            <div class="navLeftHome">
                <a href="../home/home.php"><img src="../assets/img/iconfinder_m-16_4230548.png" alt=""></a>
            </div>
            <div class="greeting" id="greeting"></div>
            <div class="navLeftTrending">
                <a href="../ranking/ranking.php">TOP<img src="../assets/img/iconfinder_Business_and_Finance_finance_pyramid_6588675.png" alt=""></a>
            </div>
            <div class="navLeftAbout">
                <a href="../aboutus/aboutus.php">About us <img src="../assets/img/iconfinder_about-info-information_2931180.png" alt=""></a>
            </div>
        </div>
        <div class="navRight">
            <div class="navSearch">
                <div class="navSearchHeader ">
                    <i class="icon icon-search"></i>
                </div>
                <div class="navSearchContent ">
                    <form action="../search/search.php" class='searchForm'>
                        <input type="text" name='seach' class="navSearchInput">
                    </form>
                </div>
            </div>
            <div class="navMenu ">
                <div class="navMenuHeader ">
                    <i class="icon icon-menu"></i>
                </div>
                <div class="navMenuContent ">
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo '<script>
                        window.user=' . json_encode($_SESSION['user']) . '
                            </script>';
                        echo '<div class="navMenuOptions">
                            <div class="optionHeader">
                            <div class="optionHeaderImgWrapper">
                            <img class="optionHeaderImg" src="../assets/img/5740bb4e1da387df4d92a09475c9b049.png" alt="">
                            </div><b>' . $_SESSION['user']['name'] . '</b></div>
                            <span class="line"></span>
                            <div class="options"><a href="../profile/profile.php?profile=' . $_SESSION['user']['member_id'] . '">View my profile</a></div>
                            <div class="options"><a href="../post/my-list.php">Posts manager</a></div>
                            <div class="options">Setting</div>
                            <span class="line"></span>
                            <div class="options"><a href="../login/login.php?logout=1">Log out</a></div>
                            </div>';
                    } else {
                        echo html_entity_decode('<div class="loginNavMenuOptions">
                            <div class="loginOption reg"><a href="../register/register.php">Create Account</a></div>
                            <div class="loginOption log"><a href="../login/login.php">Login</a></div>
                            </div>');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>