<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css">
    <link rel='stylesheet' type='text/css' href='../common/css/header.css'>
    <link rel="stylesheet" href="../assets/fontawesome-free-5.15.4-web/css/all.min.css">
    <script src="main.js"></script>
    <title>Profile</title>
</head>

<body style="background-color: #eef0f1;">
    <?php require '../common/header.php'; ?>
    <?php require '../controller/member.php'; ?>
    <?php
    if (!isset($_GET['profile'])) {
        header("Location: ../home/home.php");
    }
    $profile = getProfile($_GET['profile']);
    var_dump($profile);
    ?>


    <div class="container" style="margin-top: 100px;">
        <div class="row mb-5">
            <div class="upperInfo col-12">
                <div class="userAva">
                    <img src="../assets/img/5740bb4e1da387df4d92a09475c9b049.png" alt="loi">
                </div>
                <div class="subcribtion">
                    <div class="subNumber">
                        <i class="fas fa-wifi"> </i>
                        <span class="subText"><?php echo $profile['subcribe_count']; ?></span>
                    </div>
                    <div class="subButton">
                        <input type="checkbox" id="subButtonCb" checked class="subButtonCb">
                        <label for="subButtonCb">Subcribe</label>
                    </div>
                </div>
                <div class='text-center fs-2 fw-bold'><?php echo $profile['name']; ?></div>
                <div class="d-flex flex-column align-items-center pb-3">
                    <?php
                    if ($profile['description']) {
                        echo '<div class="p-2 fst-italic ">' . $profile['description'] . '</div>';
                    }

                    ?>
                    <div>
                        <div class="d-flex justify-content-center mb-3">
                            <?php
                            if ($profile['place']) {
                                echo '<div><i class="fas fa-map-marker"></i> ' . $profile['place'] . '</div>';
                            }
                            if ($profile['joinDate']) {
                                $jDate = date_create($profile['joinDate']);
                                echo '<div><i class="fas fa-plug"></i> Joined on ' . date_format($jDate, 'F j, Y') . '</div>';
                            }
                            ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <?php
                            if ($profile['contacts']) {
                                $countContacts = count($profile['contacts']);
                                for ($i = 0; $i < $profile['contacts']; $i++) {
                                    echo '<a href="' . $profile['contacts'][$i]['value'] . '"><i class="fab fa-' . $profile['contacts'][$i]['type'] . '"></i></a>';
                                }
                            }
                            ?>

                            <!-- <a href="#"><i class="fab fa-facebook-square"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-stack-overflow"></i></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-3 ">
                <div class="bg-white border shadow-sm p-3 fs-5 mb-3" style="border-radius:10px">
                    <?php
                    if ($profile['job']) {
                        echo '<div class="my-1">
                    <span class="fw-bold">Job:</span> student ' . $profile['job'] . '
                    </div>';
                    }
                    if ($profile['dateOfBirth']) {
                        $dob = date_create($profile['dateOfBirth']);
                        echo '<div class="my-1">
                        <span class="fw-bold">Job:</span> Year born ' . date_format($dob, 'Y') . '
                        </div>';
                    }
                    ?>
                </div>
                <div class="bg-white border shadow-sm p-3" style="border-radius:10px">
                    <div class="my-2">
                        <i class="far fa-file-alt fs-5 me-2"></i><?php echo getUserAllPostsCount($_GET['profile']); ?> posts published
                    </div>
                    <div class="my-2">
                        <i class="far fa-comment-dots fs-5 me-1"></i><?php echo getUserAllCommentsCount($_GET['profile']); ?> comments written
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="postheader">
                    <div class="sort">
                        <div class="sorticon"></div>
                        <div href="" id='sortNewest' class="sortType">
                            <i class="sortIcon "></i>
                            Newest
                        </div>
                        <div href="" id='sortAz' class="sortType">
                            <i class="sortIcon fa fa-sort"></i>
                            A-Z
                        </div>
                        <div href="" id='sortView' class="sortType">
                            <i class="sortIcon"></i>
                            View
                        </div>
                    </div>
                </div>
                <div class="listpost">
                    <!--  -->
                    <!-- <div class="postcontainer">
                        <a href="">
                            <div class="fs-2 fw-bold">title</div>
                            <p class="postdescription">preContent</p>
                            <div class="postimg">
                                <img src="../${v.preImg}" alt="">
                            </div>
                        </a>
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class='mx-2'>View: ${v.view}</span>
                                <span class='mx-2'>Vote: ${v.vote}</span>
                            </div>
                            <span class="fst-italic text-secondary">${updatedTime}</span>
                        </div>
                    </div> -->
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
    <?php require '../common/footer.php'; ?>

</body>

</html>