<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../common/css/base.css">
    <link rel="stylesheet" href="./main.css">
    <script src="./home.js"></script>
</head>

<body>
    <?php require '../common/header.php';
    require '../controller/post.php';
    $lastestPosts = getLastestPost();  
    $lastestNews = getLastestNews();
    ?>
    <div class="container my-5">
        <!-- <div class="main-container"> -->
        <!-- <div class="row trending-bar p-2">
            <div class="d-flex justify-content-between trending-bar">
                <div class="trend-label">TRENDING</div>
                <div>
                    <a href="#">CES 2020</a>
                </div>
                <div><a href="#">AI</a>
                </div>
                <div><a href="#">Best CPU</a>
                </div>
                <div><a href="#">Best Phone</a>
                </div>
                <div><a href="#">Marvel Movies</a>
                </div>
                <div><a href="#">COVID-19 vaccines</a>
                </div>
                <div><a href="#">VPN</a>
                </div>
            </div>
        </div> -->
        <aside class="my-5"><small> -- You can not use up creativity. The more you use, the more you have. -- Maya Angelou, 2011</small></aside>

        <div class="row">
            <div class="col-md-8">
                <div id="new-posts" class="row">
                    <!-- <div class="col-md-7 ">
                        <div class="article flex-column">
                            <div style="width: 100%;height: 200px;">
                                <a href="../post/post.html"><img style="width: 100%;height: 100%;" src="../assets/img/post1-col1.jpg" alt="post1-col1"></a>
                            </div>
                            <div class="item-detail">
                                <div class="item-type-post">TECH</div>
                                <a href="../post/post.html" class="item-link">
                                    <h2>What is DEVOPS ?</h2>
                                </a>
                                <span class="item-author">AUTHOR 1</span><br>
                                <span class="item-author">25 March, 2021</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 ">
                        <div class="article flex-column">
                            <div style="width: 100%;height: 200px; ">
                                <a href="../post/post.html"><img style="width: 100%;height: 100%;" src="../assets/img/post1-col1.jpg" alt="post1-col1"></a>
                            </div>
                            <div class="item-detail">
                                <div class="item-type-post">TECH</div>
                                <a href="../post/post.html" class="item-link">
                                    <h2>What is DEVOPS ?</h2>
                                </a>
                                <span class="item-author">AUTHOR 1</span><br>
                                <span class="item-author">25 March, 2021</span>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div id="sub-new-posts" class="row my-5">
                    <div class="col-md-6 ">
                        <div class="article">
                            <div style="width: 30%">
                                <a href="../post/post.html"><img style="width: 100%;height: 100%;" src="../assets/img/post1-col1.jpg" alt="post1-col1"></a>
                            </div>
                            <div class="item-detail">
                                <div class="item-type-post">TECH</div>
                                <a href="../post/post.html" class="item-link">
                                    <h2>What is DEVOPS ?</h2>
                                </a>
                                <span class="item-author">AUTHOR 1</span><br>
                                <span class="item-author">25 March, 2021</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="article">
                            <div style="width: 30%">
                                <a href="../post/post.html"><img style="width: 100%;height: 100%;" src="../assets/img/post1-col1.jpg" alt="post1-col1"></a>
                            </div>
                            <div class="item-detail">
                                <div class="item-type-post">TECH</div>
                                <a href="../post/post.html" class="item-link">
                                    <h2>What is DEVOPS ?</h2>
                                </a>
                                <span class="item-author">AUTHOR 1</span><br>
                                <span class="item-author">25 March, 2021</span>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="list-posts" class="row my-5">
                    <div class="col-md-12">
                        <div class="article">
                            <!-- <a href="../post/post.html"><img src="../assets/img/post1-col1.jpg" alt="post1-col1"></a> -->
                            <div class="item-detail">
                                <div class="item-type-post">TECH</div>
                                <a href="../post/post.html" class="item-link">
                                    <h2>What is DEVOPS ?</h2>
                                </a>
                                <span class="item-author">AUTHOR 1</span><br>
                                <span class="item-author">25 March, 2021</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="load-more">
                    <h5>Learn more ...</h5>
                </div>
            </div>

            <!-- -------------------------------------------------col2 -------------------------------------------------->
            <div class="col-md-4 border-3 border-top border-dark ">
                <div class="p-3 fw-bold " style="border-bottom: 1px solid var(--stick-color);">
                    <h1>Most Popular</h1>
                </div>
                <div id="list-news">
                    <!-- <div class="story">
                        <img style="width:30%; object-fit:cover; object-position:center;" src="../assets/img/post1.jfif">
                        <div class="story-detail ms-2">
                            <div class="type-post">NEWS</div>
                            <a href="#" class="story-link">
                                <h3>COVID-19 vaccines updates</h3>
                            </a>
                            <span class="author">AUTHOR 2</span><br>
                            <span>25 March, 2021</span>
                        </div>
                    </div> -->
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
    <!------------------------------------------------- footer -------------------------------------------------->
    <?php require '../common/footer.php' ?>
</body>

</html>