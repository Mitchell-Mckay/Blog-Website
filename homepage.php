<?php
session_start();

if (isset($_SESSION['username'])) {
  if ($_SESSION['level'] == '1') {
    $header = '<div class="header">
                <a href="#default" class="logo">Meesh Blog</a>
                  <div class="header-right">
                    <a class="active" href="homepage.php">Home</a>
                    <a href="#contact">Contact</a>
                    <a class="createpost" href="create-post.php">Create Post</a>
                    <a href="logout.php">Logout</a>
                    <a class = "register" href="edit_user.php">Edit Profile</a>
                  </div>
                </div>';
  } else {
    $header = '<div class="header">
    <a href="#default" class="logo">Meesh Blog</a>
      <div class="header-right">
        <a class="active" href="homepage.php">Home</a>
        <a href="#contact">Contact</a>
        <a class="createpost" href="create-post.php">Create Post</a>
        <a href="logout.php">Logout</a>
        <a class = "register" href="admin.php">Admin</a>
      </div>
    </div>';
  }
} else {
  $header = '<div class="header">
  <a href="#default" class="logo">Meesh Blog</a>
    <div class="header-right">
      <a class="active" href="homepage.php">Home</a>
      <a href="#contact">Contact</a>
      <a class="createpost" href="create-post.php">Create Post</a>
      <a href="login.php">Sign In</a>
      <a class = "register" href="register.php">Get Started</a>
    </div>
  </div>';
}


?>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }

    .header {
      overflow: hidden;
      background-color: #f1f1f1;
      padding: 20px 10px;
    }

    .header a {
      float: left;
      color: black;
      text-align: center;
      padding: 12px;
      text-decoration: none;
      font-size: 18px;
      line-height: 25px;
      border-radius: 4px;
    }

    .header a.logo {
      font-size: 25px;
      font-weight: bold;
    }

    .header a:hover {
      background-color: #ddd;
      color: black;
    }

    .header a.active {
      background-color: dodgerblue;
      color: white;
    }

    .header a.createpost {
      background-color: greenyellow;
      color: black;
    }

    .header-right {
      float: right;
    }

    .header a.register {
      background-color: black;
      color: white;
      border-radius: 47%;
    }
  </style>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
</head>

<body>
  <!-- Header -->

  <?php echo $header; ?>

  <h2>Categories</h2>

  <?php
  require('dbc.php');

  $query = "SELECT * FROM `category`";

  $result = mysqli_query($conn, $query) or die("Bad query");
  ?>

  <form id="category-form" method="GET" action="articlelist.php">

    <table id="categories" class="display" width="100%" cellpadding="5px">

      <thead>
        <tr>
          <th> ID </th>
          <th> Category </th>
          <th> Description </th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_array($result)) {
          $category_id = $row['category_id'];
          $categoryidbutton = "<input type='radio' name='categoryid' id='categoryid' value='$category_id'>";
        ?>
          <tr>
            <td> <?php echo $categoryidbutton; ?> </td>
            <td> <?php echo $row['category'];; ?> </td>
            <td> <?php echo $row['description'];; ?> </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>

    <br>

    <input type="submit" name="showarticles" value="SHOW ARTICLES!">

  </form>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

  <script>
    $(document).ready(function() {
      $('#categories').DataTable();
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>

</html>