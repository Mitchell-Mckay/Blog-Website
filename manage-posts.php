<?php

session_start();

require('dbc.php');

$post_id = array();
$title = array();
$datecreated = array();
$category = array();

$query = "SELECT posts.post_id, posts.title, posts.postCreated, posts.publish_stat, category.category 
FROM posts 
JOIN category ON posts.category_id = category.category_id 
ORDER BY posts.post_id ASC;";

$result = mysqli_query($conn, $query) or die("Bad query");

while ($row = mysqli_fetch_array($result)) {
    $publish_stat = $row['publish_stat'];
    if ($publish_stat == "Yes") {
        if (substr($row['postCreated'], 0, -9) == date("Y-m-d") or substr($row['postCreated'], 0, -9) == date('Y-m-d', strtotime("-1 days"))) {
            $post_id[] = $row['post_id'];
            $title[] = $row['title'];
            $datecreated[] = substr($row['postCreated'], 0, -9);
            $category[] = $row['category'];
        }
    }
}

if (isset($_GET['editButton'])) {
    $post_id2 = $_GET['postid'];

    header("Location:edit-post.php?postid=$post_id2");
} elseif (isset($_GET['Publish'])) {
    $post_id2 = $_GET['postid'];

    $query2 = "UPDATE `posts` SET `publish_stat` = 'Yes' WHERE `posts`.`post_id` = '$post_id2'";

    mysqli_query($conn, $query2) or die('Bad query');
} elseif (isset($_GET['Unpublish'])) {
    $post_id2 = $_GET['postid'];

    $query2 = "UPDATE `posts` SET `publish_stat` = 'No' WHERE `posts`.`post_id` = '$post_id2'";

    mysqli_query($conn, $query2) or die('Bad query');
}

$query3 = "SELECT posts.post_id, posts.title, posts.content, posts.postCreated, posts.postUpdated, posts.publish_stat, posts.view_count, category.category
FROM `posts` JOIN category ON posts.category_id = category.category_id";

$result2 = mysqli_query($conn, $query3) or die("Bad query");

?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>MeeshBlogs</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="imgs/logo.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />

    <!-- Template Main CSS Files -->
    <link href="assets/css/variables.css" rel="stylesheet" />
    <link href="assets/css/main.css" rel="stylesheet" />

    <!-- CK Editor -->
    <script src="ckeditor4/ckeditor/ckeditor.js"></script>
</head>


<body>
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="imgs/logo.png" alt="">
                <h1>MeeshBlogs</h1>
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="create-post.php">Create Post</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="edit_user.php">Edit Profile</a></li>
                    <li><a href="admin.php">Admin</a></li>
                    <li class="dropdown">
                        <a href="admin.php"><span>MANAGE</span>
                            <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="manage-posts.php">Posts</a></li>
                            <li><a href="manage-categories.php">Categories</a></li>
                            <li><a href="manage-comments.php">Comments</a></li>
                            <li><a href="manage-users.php">Users</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- .navbar -->

            <div class="position-relative">

                <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
                <i class="bi bi-list mobile-nav-toggle"></i>

                <!-- ======= Search Form ======= -->
                <div class="search-form-wrap js-search-form-wrap">
                    <form action="search-result.html" class="search-form">
                        <span class="icon bi-search"></span>
                        <input type="text" placeholder="Search" class="form-control" />
                        <button class="btn js-search-close">
                            <span class="bi-x"></span>
                        </button>
                    </form>
                </div>
                <!-- End Search Form -->
            </div>
        </div>
    </header>

    <main id="main">
        <section>
            <div class="container">
                <div class="row">
                    <div data-aos="fade-up">
                        <div class="text-center">
                            <h1 class="page-title">Manage Posts</h1>
                        </div>
                        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                            <table id="posts" width="100%" cellpadding="5px">

                                <thead>
                                    <tr>
                                        <th> ID </th>
                                        <th> Title </th>
                                        <th> Snippet </th>
                                        <th> Category </th>
                                        <th> Created </th>
                                        <th> Updated </th>
                                        <th> View Count </th>
                                        <th> Published? </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $post_id2 = $row2['post_id'];
                                        $postidbutton = "<input type = 'radio' name = 'postid' id = 'postid' value = '$post_id2'>";
                                    ?>
                                        <tr>
                                            <td> <?php echo $postidbutton . $post_id2; ?> </td>
                                            <td style="width:23%"> <?php echo $row2['title']; ?> </td>
                                            <td style="width:38%"> <?php echo substr($row2['content'], 0, 76) . substr($row2['content'], 76, 80) . "..."; ?> </td>
                                            <td> <?php echo $row2['category']; ?> </td>
                                            <td> <?php echo $row2['postCreated']; ?> </td>
                                            <td> <?php echo $row2['postUpdated']; ?> </td>
                                            <td> <?php echo $row2['view_count']; ?> </td>
                                            <td> <?php echo $row2['publish_stat']; ?> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                            </table>
                            <div class=" col-12">
                                <input class="btn btn-primary" type="submit" name="editButton" value="EDIT" />
                                <input class="btn btn-primary" type="submit" name="Publish" value="PUBLISH" />
                                <input class="btn btn-primary" type="submit" name="Unpublish" value="UNPUBLISH" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Trending Section -->
    </main>
    <!-- End #main -->
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="footer-content">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-4">
                        <h3 class="footer-heading">About MeeshBlogs</h3>
                        <p>
                            Welcome to MeeshBlogs, a website dedicated to bringing you the latest and most insightful information about a wide range of topics. Our website is run by an alien inspector who has taken on the mission of spreading knowledge and awareness to the human population.
                            Our alien inspector has traveled to different parts of the universe and has seen things that most humans can only imagine. With their unique perspective and expertise, they have created a platform that offers a fresh and exciting take on the world around us.
                        </p>
                        <p>
                            Thank you for visiting our website, and we hope you enjoy reading our articles as much as we enjoy creating them.
                        </p>
                    </div>
                    <div class="col-6 col-lg-2">
                        <h3 class="footer-heading">Navigation</h3>
                        <ul class="footer-links list-unstyled">
                            <li>
                                <a href="index.php"><i class="bi bi-chevron-right"></i> Home</a>
                            </li>
                            <li>
                                <a href="create-post.php"><i class="bi bi-chevron-right"></i> Create Post</a>
                            </li>
                            <li>
                                <a href="fullarticlelist.php"><i class="bi bi-chevron-right"></i> Article List</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6 col-lg-2">
                        <h3 class="footer-heading">Categories</h3>
                        <ul class="footer-links list-unstyled">
                            <li>
                                <a href="articlelist.php?categoryid=1"><i class="bi bi-chevron-right"></i> Food</a>
                            </li>
                            <li>
                                <a href="articlelist.php?categoryid=2"><i class="bi bi-chevron-right"></i> Travel</a>
                            </li>
                            <li>
                                <a href="articlelist.php?categoryid=3"><i class="bi bi-chevron-right"></i> Health & Fitness</a>
                            </li>
                            <li>
                                <a href="articlelist.php?categoryid=4"><i class="bi bi-chevron-right"></i> Fashion & Beauty</a>
                            </li>
                            <li>
                                <a href="articlelist.php?categoryid=5"><i class="bi bi-chevron-right"></i> Photography</a>
                            </li>
                            <li>
                                <a href="articlelist.php?categoryid=6"><i class="bi bi-chevron-right"></i> Music</a>
                            </li>
                            <li>
                                <a href="articlelist.php?categoryid=7"><i class="bi bi-chevron-right"></i> Business</a>
                            </li>
                            <li>
                                <a href="articlelist.php?categoryid=8"><i class="bi bi-chevron-right"></i> Sports</a>
                            </li>
                            <li>
                                <a href="articlelist.php?categoryid=9"><i class="bi bi-chevron-right"></i> Political News</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-4">
                        <h3 class="footer-heading">Recent Posts</h3>

                        <ul class="footer-links footer-blog-entry list-unstyled">

                            <?php
                            for ($c = 0; $c < count($post_id); $c++) {
                                echo "<li>
                                <a href='singlearticle.php?postid=$post_id[$c]' class='d-flex align-items-center'>
                                    <img src='imgs/$c.png' alt='' class='img-fluid me-3' />
                                    <div>
                                    <div class='post-meta d-block'>
                                        <span class='date'>$category[$c]</span>
                                        <span class='mx-1'>&bullet;</span>
                                        <span>$datecreated[$c]</span>
                                    </div>
                                    <span>$title[$c]</span>
                                    </div>
                                </a>
                                </li>";
                            }
                            ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>

        <!-- DataTables -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function() {
                $('#posts').DataTable();
            });
        </script>
</body>

</html>