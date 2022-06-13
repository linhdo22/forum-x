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
    <link rel="stylesheet" href="./main.css">
    <script src="./main.js"></script>
    <title>Search</title>
</head>
  
<body>
    <?php require '../common/header.php' ?>
    <div class="container">
        <div class="row mt-5">
            <div class="sideTag col-md-3 py-3 pe-4">
                <div class="fs-3">Search filter results</div>
                <ul class="listType">
                    <li id="filTypeAll" class="filterType active">All</li>
                    <li id="filPost" class="filterType">Post</li>
                    <li id="filComment" class="filterType">Comment</li>
                    <li id="filUser" class="filterType">User</li>  
                </ul>
                <ul class="listTag">
                    <li id="filTagAll" class="filterTag fst-italic active">All</li>
                    <li id="filArt" class="filterTag fst-italic ">#Art</li>
                    <li id="filBiology" class="filterTag fst-italic ">#Biology</li>
                    <li id="filMechanic" class="filterTag fst-italic ">#Mechanic</li>
                    <li id="filNews" class="filterTag fst-italic ">#News</li>
                    <li id="filScience" class="filterTag fst-italic ">#Science</li>
                    <li id="filSocial" class="filterTag fst-italic ">#Social</li>
                    <li id="filTech" class="filterTag fst-italic ">#Tech</li>
                </ul>
            </div>
            <div class="col-md-9 py-3 ps-4 pe-2">
                <div class="searchBar">
                    <div class="searchBarForm">
                        <input id="search-bar-input" class="w-100 p-2" type="text" value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>'>
                        <i class="fas fa-search fs-3 searchBarIcon"></i>
                    </div>
                </div>
                <div>
                    <!-- <div class="d-flex justify-content-end fs-5 my-4">
                        <div class="resultSort">
                            <div id="sortRelevant" class="sort active">Most Relevant</div>
                            <div id="sortNew" class="sort">Newest</div>
                            <div id="sortName" class="sort">A - Z</div>
                            <div id="sortView" class="sort">View</div>
                        </div>
                    </div> -->
                    <div class="searchResult animation-second my-4">

                        <!-- code js  -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php require '../common/footer.php' ?>
</body>

</html>