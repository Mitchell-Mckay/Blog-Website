<?php
require('dbc.php');
$query = "SELECT posts.post_id, posts.title FROM `posts` ORDER BY posts.view_count DESC;";

$result = mysqli_query($conn, $query) or die("Bad query");
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
               <li><a href="edit_user.php">Edit Profile</a></li>
               <li class="dropdown">
                  <a href="admin.php"><span><strong>MANAGE</strong></span>
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
               <canvas id="viewsChart" class="w-100" style="height: 400px; border-radius: 0.5rem;"></canvas>
               <table id="posts" width="100%" cellpadding="5px">

                  <thead>
                     <tr>
                        <th> ID </th>
                        <th> Title </th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     while ($row = mysqli_fetch_array($result)) {
                     ?>
                        <tr>
                           <td> <?php echo $row['post_id']; ?> </td>
                           <td> <?php echo $row['title']; ?> </td>
                        </tr>
                     <?php
                     }
                     ?>
               </table>
            </div>
         </div>
      </section>
   </main>

   <script>
      const chartLabels = [];
      const chartData = [];
      fetch('get_views_data.php')
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