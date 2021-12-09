<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/fontawesome-free-5.15.4-web/css/all.min.css">
    <title>POST</title>
    <link rel="stylesheet" href="../common/css/base.css">
    <link rel="stylesheet" href="./post.css">
    <script src="./post.js"></script>

</head>

<body>
    <?php require '../common/header.php'; ?>
    <?php require '../controller/post.php'; ?>
    <?php
    if (!isset($_GET['id'])) {
        header('Location: ../home/home.php');
    }
    $post = getPost($_GET['id']);
    if (!$post || $post['public'] == '0' && $_SESSION['user']['member_id'] != $post['author']) {
        header('Location: ../home/home.php');
    }
    $authorId = $post['author'];
    echo "<script> window.authorId = $authorId </script>";
    ?>


    <div class="container my-5">
        <?php
        if (!$post || $post['public'] == '0' && $_SESSION['user']['member_id'] == $post['author']) {
            echo '<h2 class="text-info text-center mb-5 border border-3 rounded border-info" >This post is under private status now, only you can see it!</h2>';
        }
        ?>
        <div class="row">
            <div class="col-md-9">
                <div class="p-3 post-content">
                    <h1 class="pb-2"><?php echo $post['title'] ?></h1>
                    <?php echo $post['content']; ?>

                </div>
                <?php echo '<p class="text-end mt-2 p-2"><b>Last Modified </b>' . $post['updatedAt'] . '</p>'; ?>
                <div class="mt-5">
                    <p class="fs-4">Commments</p>
                    <?php
                    if ($post['public'] == '1') {

                        echo '<textarea id="textare" placeholder="Leave a comment"></textarea>';
                        echo '<div id="write-comment-warn" style="display: none;" class="text-danger">You must login to comment this post</div>';
                        echo '<div id="create-comment" class="btn btn-success my-3">Write comment</div>';

                        echo '<script src="../common/js/tinymce/js/tinymce/tinymce.min.js"></script>';
                        echo "<script>
                        tinymce.init({
                            resize:false,
                            height:150,
                            selector: 'textarea',
                            plugins: 'advlist link image lists',
                            menubar: false,
                            toolbar: ' bold italic | forecolor backcolor',
                        });
                        </script>";
                    }

                    ?>

                    <div id="comment-list" class="" style="min-height:10vh">
                        <!--  -->
                        <!-- <div class="border shadow-sm mb-4 p-3 ">
                            <div class=" d-flex justify-content-between my-2 ">
                                <div class="fw-bold fst-italic">Ten</div>
                                <div class="fw-light"> Time</div>
                            </div>
                            <div>content</div>
                        </div> -->
                        <!--  -->
                    </div>
                    <div id="pageination-comment">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                            <li class="page-item"><span class="page-link btn">1</span></li>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link btn">2</span>
                            </li>
                            <li class="page-item"><span class="page-link btn">3</span></li>
                            <li class="page-item">
                                <span class="page-link btn">Next</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-md-3 ">
                <div class="post-author p-2">
                    <a href="../profile/profile.php?profile=<?php echo $post['author']; ?>">
                        <div class="text-center author-image">
                            <!-- <img src="../assets/img/iconfinder_batman_hero_avatar_comics_4043232.png" alt="ava-author"> -->
                            <img src="../assets/img/5740bb4e1da387df4d92a09475c9b049.png" alt="ava-author">
                        </div>
                    </a>
                    <h4 class="border-top">Name</h4>
                    <p><?php echo $post['name']; ?></p>

                    <?php
                    if ($post['job']) {
                        echo '<h4 class="border-top">Work</h4>
                        <p>' . $post['job'] . '</p>';
                    }
                    if ($post['place']) {
                        echo '<h4 class="border-top">Location</h4>
                        <p>' . $post['place'] . '</p>';
                    }
                    if ($post['joinDate']) {
                        $joindate = strtotime($post['joinDate']);
                        echo '<h4 class="border-top">Joined</h4>
                        <p>' . date('F j, Y', $joindate) . '</p>';
                    }

                    ?>
                </div>

            </div>
        </div>
    </div>
    <?php require '../common/footer.php' ?>
    <!-- post info -->
    <?php
    $userVote;
    if (!isset($_SESSION['user'])) {
        $userVote = 0;
    } else {
        $userVote = checkUserVote($post['post_id'], $_SESSION['user']['member_id']);
    }
    echo $userVote;
    ?>
    <div id="post-info" class="vstack gap-5 text-center">
        <div>
            <p id="up-vote" class="btn text-<?php echo $userVote == '1' ? "primary" : "dark"; ?> btn-outline-light"><i class="fas fa-chevron-up fs-5 "></i></p>
            <p id="count-vote" class="fs-4"><?php echo $post['vote'] ?></p>
            <p id="down-vote" class="btn text-<?php echo $userVote == '-1' ? "danger" : "dark"; ?> btn-outline-light"><i class="fas fa-chevron-down fs-5 "></i></p>
        </div>
        <div><i class="me-1 fas fa-eye"></i> <?php echo $post['view'] ?></div>
    </div>
    <?php
    if (!isset($_SESSION['read-post'])) {
        $_SESSION['read-post'] = array();
    }
    if (!in_array($post['post_id'], $_SESSION['read-post'])) {
        $_SESSION['read-post'][] = $post['post_id'];
        echo "<script>updateView()</script>";
    }
    ?>
</body>

</html>