<script src="../common/js/jquery-3.6.0.min.js"></script>
<link rel='stylesheet' href='../common/css/header.css'>
<script src='../common/js/header.js'></script>
<script src='../assets/js/popper.min.js'></script>
<script src="../assets/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
<link rel='stylesheet' href='../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css'>
<link rel="stylesheet" href="../assets/fontawesome-free-5.15.4-web/css/all.min.css">

<!-- messenger -->
<script src="../common/js/config.js"></script>
<script src="../assets/js/socket.io.min.js"></script>
<script src="../common/js/socket.js"></script>
<script src="../common/js/tab-manager.js"></script>
<script src="../common/js/messenger.js"></script>
<script src="../common/js/messenger-api.js"></script>
<link rel='stylesheet' href='../common/css/messenger.css'>


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
                    <div id="navSearchHeader" class="btn">
                        <i class="fas fa-search fs-4"></i>
                    </div>
                    <div class="navSearchContent pt-2">
                        <form action="../search/search.php" id='searchForm'>
                            <input type="text" name='search' class="navSearchInput">
                        </form>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['user'])) {
                    // this shouldn't use bootstrap , should use btn and manage by js for prenting re-render each new message
                    echo '<div class="dropdown">
                    <div id="messenger-title" class="btn disabled position-relative" data-bs-toggle="dropdown">
                        <i class="fas fa-comments fs-4 "></i>
                        <span id="noti-new-message" class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle d-none"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end p-2 rounded shadow pt-0" >
                        <div class="fs-4 my-2">
                            Messenger
                        </div>
                        <div id="message-list" class="overflow-hidden" style="width:400px">
                            
                        </div>
                    </div>
                    
                    </div>';
                }
                ?>
                <div class="dropdown">
                    <div class="btn" data-bs-toggle="dropdown">
                        <i class="fas fa-bars fs-4"></i>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end p-2 rounded shadow" style="width:220px;">
                        <?php
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
                                <a class="dropdown-item" href="../login/login.php?logout=1">Log out</a>';
                        } else {
                            echo '<div class="loginNavMenuOptions">
                            <a class="btn btn-outline-white w-100" href="../register/register.php">Create Account</a>
                            <a class="btn btn-primary w-100 text-white" href="../login/login.php">Login</a>
                            </div>';
                        }
                        ?></div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- bubble chat  -->
<div id="bubble-container" class="position-fixed end-0 bottom-0 d-flex align-items-end">
    <div id="converstation-list" class="d-flex">
        <!-- <div class="bg-white mx-2 d-flex flex-column border border-secondary rounded-top" style="width: 250px;height:350px;">
            <div class="bg-primary p-2 d-flex text-white align-items-center">
                <div class="fs-5">Name</div>
                <div class="ms-auto">
                    <i class="btn fas fa-times fs-4 p-0 text-white"></i>
                </div>
            </div>
            <div class="bg-white flex-fill p-2">
                <div class="d-flex align-items-center">
                    <div>a</div>
                    <div class="chat-message bg-primary text-white p-1 mx-1">text</div>
                </div>
                <div class="d-flex flex-row-reverse">
                    <div>a</div>
                    <div>text</div>
                </div>
            </div>
            <div class="border-top p-2">
                <textarea placeholder="Send a wish" class="chat-input p-1"></textarea>
            </div>
        </div> -->
    </div>
    <div id="bubble-list" class="m-2">
        <!-- <div class="bubble-chat my-2">
            <img src="../upload-image/avatar/avatar-1.jpg" class="rounded-circle">
            <i class="btn fas fa-times p-0 text-white rounded-circle"></i>
        </div> -->
    </div>
</div>