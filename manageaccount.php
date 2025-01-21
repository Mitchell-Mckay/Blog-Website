<?php
session_start();

$user_id = $_SESSION['user_id'];

require('dbc.php');

$query = "SELECT posts.post_id, posts.title, posts.publish_stat
FROM `posts` 
WHERE `posts`.`author_id` = '$user_id'
ORDER BY posts.view_count DESC;";

$result = mysqli_query($conn, $query) or die("Bad query");


if (isset($_GET['editButton'])) {
   $post_id = $_GET['postid'];

   header("Location:edit-post.php?postid=$post_id");
} elseif (isset($_GET['Publish'])) {
   $post_id = $_GET['postid'];

   $query2 = "UPDATE `posts` SET `publish_stat` = 'Yes' WHERE `posts`.`post_id` = '$post_id'";

   mysqli_query($conn, $query2) or die('Bad query');

   header("Location:manageaccount.php");
} elseif (isset($_GET['Unpublish'])) {
   $post_id = $_GET['postid'];

   $query2 = "UPDATE `posts` SET `publish_stat` = 'No' WHERE `posts`.`post_id` = '$post_id'";

   mysqli_query($conn, $query2) or die('Bad query');

   header("Location:manageaccount.php");
}


if (isset($_GET['editButton2'])) {
   $comment_id = $_GET['commentid'];

   header("Location:edit-comment.php?commentid=$comment_id");
} elseif (isset($_GET['Publish2'])) {
   $comment_id = $_GET['commentid'];

   $query2 = "UPDATE `comments` SET `publish_stat` = 'Yes' WHERE `comments`.`comment_id` = '$comment_id'";

   mysqli_query($conn, $query2) or die('Bad query');
} elseif (isset($_GET['Unpublish2'])) {
   $comment_id = $_GET['commentid'];

   $query2 = "UPDATE `comments` SET `publish_stat` = 'No' WHERE `comments`.`comment_id` = '$comment_id'";

   mysqli_query($conn, $query2) or die('Bad query');
}

$query3 = "SELECT comments.comment_id, comments.post_id, users.user_id, posts.title, users.fname, users.sname, comments.content, comments.publishedAt, comments.publish_stat
FROM `comments` JOIN posts ON comments.post_id = posts.post_id JOIN users ON comments.user_id = users.user_id WHERE `comments`.`user_id` = '$user_id'";

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

   <!-- Chart.js -->
   <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

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
               <li><a href="manageaccount.php">Manage Account</a></li>
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
               <div class="col mb-4">
                  <button class="btn btn-primary" style="width:100%" onclick="location.href='edit_user.php'">
                     <a>UPDATE PROFILE</a>
                  </button>
               </div>
               <canvas id="viewsChart" class="w-100" style="height: 400px; border-radius: 0.5rem;"></canvas>
               <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <div class="text-center">
                     <h3 class="col mb-3">Posts</h3>
                  </div>
                  <table id="posts" width="100%" cellpadding="5px">

                     <thead>
                        <tr>
                           <th> ID </th>
                           <th> Title </th>
                           <th> Published? </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                           $post_id = $row['post_id'];
                           $postidbutton = "<input type = 'radio' name = 'postid' id = 'postid' value = '$post_id'>";
                        ?>
                           <tr>
                              <td> <?php echo $postidbutton . $post_id; ?> </td>
                              <td> <?php echo $row['title']; ?> </td>
                              <td> <?php echo $row['publish_stat']; ?> </td>
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
                  <div class="text-center">
                     <h3 class="col mb-3">Comments</h3>
                  </div>
                  <table id="comments" width="100%" cellpadding="5px">
                     <thead>
                        <tr>
                           <th> ID </th>
                           <th> Post </th>
                           <th> Content </th>
                           <th> Published </th>
                           <th> Active? </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        while ($row2 = mysqli_fetch_array($result2)) {
                           $comment_id = $row2['comment_id'];
                           $commentidbutton = "<input type = 'radio' name = 'commentid' id = 'commentid' value = '$comment_id'>";
                        ?>
                           <tr>
                              <td> <?php echo $commentidbutton . $comment_id; ?> </td>
                              <td style="width:35%"> <?php echo $row2['title']; ?> </td>
                              <td> <?php echo $row2['content']; ?> </td>
                              <td> <?php echo $row2['publishedAt']; ?> </td>
                              <td> <?php echo $row2['publish_stat']; ?> </td>
                           </tr>
                        <?php
                        }
                        ?>
                  </table>
                  <div class=" col-12">
                     <input class="btn btn-primary" type="submit" name="editButton2" value="EDIT" />
                     <input class="btn btn-primary" type="submit" name="Publish2" value="PUBLISH" />
                     <input class="btn btn-primary" type="submit" name="Unpublish2" value="UNPUBLISH" />
                  </div>
               </form>
            </div>
         </div>
      </section>
   </main>

   <script>
      const chartLabels = [];
      const chartData = [];
      fetch('get_views_data2.php')
         .then(response => response.json())
         .then(data => {
            data.forEach(row => {
               chartLabels.push(row.post_id);
               chartData.push(row.view_count);
            });

            const viewsChart = new Chart(document.getElementById('viewsChart'), {
               type: 'bar',
               data: {
                  labels: chartLabels,
                  datasets: [{
                     label: 'Views',
                     data: chartData,
                     backgroundColor: createGradientColors(chartData.length),
                     borderColor: 'rgba(0, 119, 204, 0.8)',
                     borderWidth: 1,
                     tension: 0.3,
                     pointRadius: 3,
                     pointBackgroundColor: 'rgba(0, 119, 204, 0.8)',
                     pointBorderColor: 'rgba(0, 119, 204, 0.8)',
                     pointHoverRadius: 6,
                     pointHoverBackgroundColor: 'rgba(0, 119, 204, 0.8)',
                     pointHoverBorderColor: 'rgba(0, 119, 204, 0.8)',
                  }]
               },
               options: {
                  scales: {
                     y: {
                        beginAtZero: true
                     }
                  },
                  title: {
                     display: true,
                     text: 'Article Views'
                  },
                  legend: {
                     position: 'right',
                     labels: {

                     }
                  }
               }
            });
         });

      function createGradientColors(numColors) {
         const colors = [];
         const colorRange = 256;

         for (let i = 0; i < numColors; i++) {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            colors.push(`rgba(${r},${g},${b}, 1)`);
         }

         return colors;
      }
   </script>

</body>

</html>