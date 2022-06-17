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
    <title>Ranking</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/js/main.js">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="./ranking.css">
</head>

<body>
    <?php
    require '../common/header.php';
    require '../controller/post.php';
    require '../controller/member.php';
    ?>
    <!---------------------------------------- header ----------------------------------------------------->
    <div class="container my-5 py-3">
        <div class="row">
            <!------------------------------------------------------ col1 ---------------------------------------------->
            <div class="col-3 px-2">
                <div class="col-base">
                    <div class="tittle">
                        <h3>Top View</h3>
                    </div>
                    <?php
                    $topViewList = getTopViewPost();
                    $topViewListCount = count($topViewList);
                    for ($i = 0; $i < $topViewListCount; $i++) {
                        $date = date_create($topViewList[$i]["time"]);
                        echo '<div class="table-order">
                        <div class="order-number">#' . ($i + 1) . '</div>
                        <div class="order-content">
                            <a href="../post/post.php?id=' . $topViewList[$i]["post_id"] . '" class="order-name">' . $topViewList[$i]["title"] . '</a><br>
                            <a href="../profile/profile.php?profile=' . $topViewList[$i]["member_id"] . '" class="order-detail">' . $topViewList[$i]["name"] . '</a><br>
                            <span class="order-date">' . date_format($date, 'M, j Y') . '</span>
                            <div>View: ' . $topViewList[$i]["view"] . '</div>
                        </div>
                    </div>';
                    }
                    ?>

                </div>
            </div>
            <div class="col-3 px-2">
                <div class="col-base">
                    <div class="tittle">
                        <h3>Top Vote</h3>
                    </div>
                    <?php
                    $topVoteList = getTopVotePost();
                    $topVoteListCount = count($topVoteList);
                    for ($i = 0; $i < $topVoteListCount; $i++) {
                        $date = date_create($topVoteList[$i]["time"]);
                        echo '<div class="table-order">
                        <div class="order-number">#' . ($i + 1) . '</div>
                        <div class="order-content">
                            <a href="../post/post.php?id=' . $topVoteList[$i]["post_id"] . '" class="order-name">' . $topVoteList[$i]["title"] . '</a><br>
                            <a href="../profile/profile.php?profile=' . $topVoteList[$i]["member_id"] . '" class="order-detail">' . $topVoteList[$i]["name"] . '</a><br>
                            <span class="order-date">' . date_format($date, 'M, j Y') . '</span>
                            <div>Vote: ' . $topVoteList[$i]["vote"] . '</div>
                        </div> 
                    </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-3 px-2">
                <div class="col-base">
                    <div class="tittle">
                        <h3>Top Author</h3>
                    </div>
                    <?php
                    $topAuthorList = getTopSubUser();
                    $topAuthorListCount = count($topAuthorList);
                    for ($i = 0; $i < $topAuthorListCount; $i++) {
                        echo '<div class="table-order">
                        <div class="order-number">#' . ($i + 1) . '</div>
                        <div class="order-content">
                            <a href="../profile/profile.php?profile=' . $topAuthorList[$i]["member_id"] . '" class="order-name">' . $topAuthorList[$i]["name"] . '</a><br>
                            <div>Subcribe: ' . $topAuthorList[$i]["subcribe"] . '</div>
                        </div>
                    </div>';
                    }
                    ?>

                </div>
            </div>
            <div class="col-3 px-2">
                <div class="col-base">
                    <div class="tittle">
                        <h3>Top Author</h3>
                    </div>
                    <?php
                    $topAuthorList = getTopSubUser();
                    $topAuthorListCount = count($topAuthorList);
                    for ($i = 0; $i < $topAuthorListCount; $i++) {
                        echo '<div class="table-order">
                        <div class="order-number">#' . ($i + 1) . '</div>
                        <div class="order-content">
                            <a href="../profile/profile.php?profile=' . $topAuthorList[$i]["member_id"] . '" class="order-name">' . $topAuthorList[$i]["name"] . '</a><br>
                            <div>Subcribe: ' . $topAuthorList[$i]["subcribe"] . '</div>
                        </div>
                    </div>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <!--------------------------------------------- footer ------------------------------------------------------>
    <?php require '../common/footer.php' ?>
    <script src="../assets/js/main.js"></script>
</body>

</html>