<?php
session_start();
require('dbc.php');

if (isset($_SESSION['username'])) {
  if ($_SESSION['level'] == '1') {
    $header = '<header id="header" class="header d-flex align-items-center fixed-top">
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
    </header>';
  } else {
    $header = '  <header id="header" class="header d-flex align-items-center fixed-top">
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
            <li><a href="admin.php">Admin</a></li>
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
    </header>';
  }
} else {
  $header = '  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="imgs/logo.png" alt="">
        <h1>MeeshBlogs</h1>
      </a>
  
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
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
  </header>';
}

if (isset($_POST['submitButton'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username) or empty($password)) {

    $msg = "fields are empty!";
  } else {

    $query = "SELECT * FROM `users` WHERE `users`.`username` = '$username'";

    $result = mysqli_query($conn, $query) or die('Bad Query');

    while ($row = mysqli_fetch_array($result)) {

      $status = $row['status'];

      if ($status == 'Active') {

        $db_password = $row['password'];

        if (password_verify($password, $db_password)) {

          $_SESSION['user_id'] = $row['user_id'];

          $_SESSION['username'] = $username;

          $_SESSION['level'] = $row['level'];

          $query2 = "UPDATE `users` SET `lastLogin` = CURRENT_TIMESTAMP WHERE `username` = '$username'";

          mysqli_query($conn, $query2) or die(mysqli_error($conn));

          header('location:index.php');

          $msg = "Passwords Match!";
        } else {

          $msg = "Passwords Do Not Match!";
        }
      } else {

        $msg = "User Inactive!";
      }
    }
  }
} else {
  $msg = "";
  $password = "";
  $username = "";
}

?>

<!DOCTYPE html>
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

</head>

<body>
  <!-- ======= Header ======= -->
  <?php echo $header; ?>
  <!-- End Header -->

  <main id="main">
    <section>
      <div class="container my-2">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <h1 class="text-center mb-5">Login</h1>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <?php if (!empty($msg)) { ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $msg; ?>
                </div>
              <?php } ?>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" maxlength="33" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="" maxlength="33" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary" name="submitButton">Login</button>
              </div>
            </form>
            <div class="text-center mt-4">
              Need an account? <a href='register.php'><strong>Register</strong></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>

</html>