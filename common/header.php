<script src="../common/js/jquery-3.6.0.min.js"></script>
<link rel='stylesheet' href='../common/css/header.css'>
<script src='../common/js/header.js'></script>
<script src='../assets/js/popper.min.js'></script>
<script src="../assets/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
<link rel='stylesheet' href='../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css'>
<link rel="stylesheet" href="../assets/fontawesome-free-5.15.4-web/css/all.min.css">

<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-4 col-md-6 navLeft d-flex">
                <div class="navLeftHome">
                    <a href="../home/home.php"><img src="../assets/img/iconfinder_m-16_4230548.png" alt=""></a>
                </div>
                <div class="greeting mt-3 pt-2 px-4 ms-4" id="greeting" style="min-width: 111px;"></div>
                <div class="navLeftTrending d-none d-lg-block ms-4 pt-3 fs-5">
                    <a class="text-decoration-none text-dark" href="../ranking/ranking.php">TOP<img src="../assets/img/iconfinder_Business_and_Finance_finance_pyramid_6588675.png" alt=""></a>
                </div>
                <div class="navLeftAbout d-none d-lg-block ms-4 pt-3 fs-5">
                    <a class="text-decoration-none text-dark" href="../aboutus/aboutus.php">About us <img src="../assets/img/iconfinder_about-info-information_2931180.png" alt=""></a>
                </div>
            </div>
            <div class="col-md-4 offset-md-2 col-7 offset-1 d-flex pt-3">
                <div class="navSearch">
                    <div class="btn navSearchHeader ">
                        <i class="fas fa-search fs-4"></i>
                    </div>
                    <div class="navSearchContent pt-2">
                        <form action="../search/search.php" class='searchForm'>
                            <input type="text" name='search' class="navSearchInput">
                        </form>
                    </div>
                </div>
                <div class="dropdown">
                    <div class="btn" data-bs-toggle="dropdown">
                        <i class="fas fa-bars fs-4"></i>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end p-2 rounded shadow" style="width:220px;">
                        <?php
                        header('Content-Type: text/html; charset=UTF-8');
                        if (isset($_SESSION['user'])) {
                            echo '<script>
                                window.user=' . json_encode($_SESSION['user']) . '
                            </script>';
                            echo '<div class="dropdown-item text-truncate">
                                    <img class="img-thumbnail rounded-circle" style="width: 50px;height: 50px;" src="../' . $_SESSION['user']['avatar'] . '" alt="">
                                    <b>' . $_SESSION['user']['name'] . '</b>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../profile/profile.php?profile=' . $_SESSION['user']['member_id'] . '">View my profile</a>
                                <a class="dropdown-item" href="../post/my-list.php">Posts manager</a>
                                <a class="dropdown-item" href="../profile/setting-profile.php">Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../login/login.php?logout=1">Log out</a>
                                </div>';
                        } else {
                            echo '<div class="loginNavMenuOptions">
                            <a class="btn btn-outline-white w-100" href="../register/register.php">Create Account</a>
                            <a class="btn btn-primary w-100 text-white" href="../login/login.php">Login</a>
                            </div>';
                        }
                        ?></div>
                    <!-- <div class=" navMenuHeader">
                        <i class="icon icon-menu  "></i>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</div>