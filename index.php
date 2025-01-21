<?php
session_start();

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
          <li><a href="manageaccount.php">Manage Account</a></li>
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

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

</head>

<body>
  <!-- ======= Header ======= -->
  <?php echo $header; ?>
  <!-- End Header -->

  <main id="main">
    <!-- ======= Hero Slider Section ======= -->
    <section id="hero-slider" class="hero-slider">
      <div class="container-md" data-aos="fade-in">
        <div class="row">
          <div class="col-12">
            <div class="swiper sliderFeaturedPosts">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <a href="fullarticlelist.php" class="img-bg d-flex align-items-end" style="
                        background-image: url('assets/img/bear.png');
                      ">
                    <div class="img-bg-inner">
                      <h2 class="page-title">
                        Start Reading.
                      </h2>
                      <h3 style="color:white">
                        Discover stories, thinking, and expertise from writers on any topic.
                      </h3>
                    </div>
                  </a>
                </div>
                <div class="swiper-slide">
                  <a href="singlearticle.php?postid=17" class="img-bg d-flex align-items-end" style="
                        background-image: url('assets/img/createpost.png');
                      ">
                    <div class="img-bg-inner">
                      <h2>
                        Creating Stunning Blog Posts with CK Editor: A Step-by-Step Guide
                      </h2>
                      <p>
                        One of the best tools for this is CK Editor, a powerful and user-friendly WYSIWYG
                        (What You See Is What You Get) editor that makes it easy to format text, add images,
                        and create links. In this article, we'll walk you through the basics of using CK Editor to write a blog post.
                      </p>
                    </div>
                  </a>
                </div>
              </div>
              <div class="custom-swiper-button-next">
                <span class="bi-chevron-right"></span>
              </div>
              <div class="custom-swiper-button-prev">
                <span class="bi-chevron-left"></span>
              </div>

              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Hero Slider Section -->

    <!-- ======= Post Grid Section ======= -->
    <section id="posts" class="posts">
      <div class="container" data-aos="fade-up">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
          <h2>Trending</h2>
          <div><a href="homepage.php" class="more">See All Categories</a></div>
        </div>
        <div class="row g-5">
          <div class="col-lg-4">
            <div class="post-entry-1 lg">
              <a href="singlearticle.php?postid=13"><img src="https://i0.wp.com/post.medicalnewstoday.com/wp-content/uploads/sites/3/2019/01/psilocybin.jpg?w=1155&amp;h=2137" alt="" class="img-fluid" /></a>
              <div class="post-meta">
                <span class="date">Health & Fitness</span>
                <span class="mx-1">&bullet;</span> <span>April 7th '23</span>
              </div>
              <h2>
                <a href="singlearticle.php?postid=13">Exploring the Potential Benefits of Magic Mushrooms for Mental Health</a>
              </h2>
              <div class="align-items-center">
                <h3 class="m-0 p-0 text-center"><br>Top Viewed Articles:</h3>
                <canvas id="viewsChart" class="w-100" style="height: 400px; border-radius: 0.5rem;"></canvas>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="row g-5">
              <div class="col-lg-4 border-start custom-border">
                <div class="post-entry-1">
                  <a href="singlearticle.php?postid=15"><img src="https://media.gq-magazine.co.uk/photos/60250691a29397b3791c6cfa/master/w_1600%2Cc_limit/110221_FD_01.jpg" alt="" class="img-fluid" /></a>
                  <div class="post-meta">
                    <span class="date">Health & Fitness</span>
                    <span class="mx-1">&bullet;</span>
                    <span>April 8th '23</span>
                  </div>
                  <h2>
                    <a href="singlearticle.php?postid=15">The Mind-Body Connection: How Working Out Can Benefit Mental Health</a>
                  </h2>
                </div>
                <div class="post-entry-1">
                  <a href="singlearticle.php?postid=8"><img src="imgs/bruh.png" alt="" class="img-fluid" /></a>
                  <div class="post-meta">
                    <span class="date">Fashion & Beauty</span>
                    <span class="mx-1">&bullet;</span>
                    <span>April 2nd '23</span>
                  </div>
                  <h2>
                    <a href="singlearticle.php?postid=8">How Marketing Strategies Contribute to Negative Self-Image</a>
                  </h2>
                </div>
                <div class="post-entry-1">
                  <a href="singlearticle.php?postid=10"><img src="https://www.joyofbaking.com/images/facebook/eggbread.jpg" alt="" class="img-fluid" /></a>
                  <div class="post-meta">
                    <span class="date">Food</span>
                    <span class="mx-1">&bullet;</span>
                    <span>April 7th '23</span>
                  </div>
                  <h2>
                    <a href="singlearticle.php?postid=10">Baking Perfect Egg Bread: Tips and Tricks for a Soft and Fluffy Loaf</a>
                  </h2>
                </div>
              </div>
              <div class="col-lg-4 border-start custom-border">
                <div class="post-entry-1">
                  <a href="singlearticle.php?postid=12"><img src="https://media.cnn.com/api/v1/images/stellar/prod/210315125224-usain-bolt-grinning-race.jpg?q=w_2912,h_1941,x_0,y_0,c_fill" alt="" class="img-fluid" /></a>
                  <div class="post-meta">
                    <span class="date">Sports</span>
                    <span class="mx-1">&bullet;</span>
                    <span>April 7th '23</span>
                  </div>
                  <h2>
                    <a href="singlearticle.php?postid=12">5 Essential Tips for Effective Sprint Training</a>
                  </h2>
                </div>
                <div class="post-entry-1">
                  <a href="singlearticle.php?postid=9"><img src="imgs/airobots.png" alt="" class="img-fluid" /></a>
                  <div class="post-meta">
                    <span class="date">Business</span>
                    <span class="mx-1">&bullet;</span>
                    <span>April 2nd '23</span>
                  </div>
                  <h2>
                    <a href="singlearticle.php?postid=9">From Automation to Personalization: How AI is Innovating Business</a>
                  </h2>
                </div>
                <div class="post-entry-1">
                  <a href="singlearticle.php?postid=6"><img src="imgs/moose.png" alt="" class="img-fluid" /></a>
                  <div class="post-meta">
                    <span class="date">Photography</span>
                    <span class="mx-1">&bullet;</span>
                    <span>April 1st '23</span>
                  </div>
                  <h2>
                    <a href="singlearticle.php?postid=6">Why I Love Photography</a>
                  </h2>
                </div>
              </div>

              <!-- Trending Categories Section -->
              <div class="col-lg-4">
                <div class="trending">
                  <h3>Categories:</h3>
                  <ul class="trending-post">
                    <li>
                      <a href="articlelist.php?categoryid=1">
                        <span class="number">1</span>
                        <h2>
                          Food
                        </h2>
                        <span class="author">Discusses food related topics such as recipes for various dishes</span>
                      </a>
                    </li>
                    <li>
                      <a href="articlelist.php?categoryid=3">
                        <span class="number">2</span>
                        <h2>
                          Health & Fitness
                        </h2>
                        <span class="author">Tips on exercise and workouts, nutritional and dietary advice</span>
                      </a>
                    </li>
                    <li>
                      <a href="articlelist.php?categoryid=7">
                        <span class="number">3</span>
                        <h2>
                          Business
                        </h2>
                        <span class="author">Entrepreneurship and startups, marketing and branding, leadership and management</span>
                      </a>
                    </li>
                    <li>
                      <a href="articlelist.php?categoryid=5">
                        <span class="number">4</span>
                        <h2>
                          Photography
                        </h2>
                        <span class="author">Different types of photography, such as landscape, portrait, wildlife, etc.</span>
                      </a>
                    </li>
                    <li>
                      <a href="articlelist.php?categoryid=8">
                        <span class="number">5</span>
                        <h2>
                          Sports
                        </h2>
                        <span class="author">Top athletes to watch in the upcoming season, upcoming draft projections, the history of sports, sports and mental health </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- End Trending Categories Section -->
            </div>
          </div>
        </div>
        <!-- End .row -->
      </div>
    </section>
    <!-- End Post Grid Section -->

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

    <!-- Chart.js -->
    <script>
      const chartLabels = [];
      const chartData = [];
      fetch('get_views_data.php')
        .then(response => response.json())
        .then(data => {
          $c = 0;
          data.forEach(row => {
            $c++;
            if ($c <= 8) {
              chartLabels.push(row.post_id);
              chartData.push(row.view_count);
            }
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