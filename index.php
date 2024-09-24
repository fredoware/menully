<?php
  session_start();
  $_SESSION['returnLink'] = '../pages/store-sign-up.php';
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Menully - Digital QR Menu</title>

  <meta property="og:title" content="Menully QR Menu" />
  <meta property="og:url" content="https://menully.com" />
  <meta property="og:image" content="https://menully.com/pages/templates/source/img/open-graph.jpg" />

  <!-- Favicons -->
  <link href="pages/templates/source/img/favicon.png" rel="icon">
  <link href="pages/templates/source/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="pages/templates/source/bootstrap.min.css" rel="stylesheet">
  <link href="pages/templates/source/bootstrap-icons.css" rel="stylesheet">
  <link href="pages/templates/source/aos.css" rel="stylesheet">
  <link href="pages/templates/source/glightbox.min.css" rel="stylesheet">
  <link href="pages/templates/source/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="pages/templates/source/main.css" rel="stylesheet">
  <link href="pages/templates/custom.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Yummy
  * Updated: Jan 30 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-lg-0">
        <img src="pages/templates/source/img/menully-logo.png" style="margin-right:15px;">
        <h1>Menully<span>,</span></h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="#hero">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#benefits">Benefits</a></li>
          <!-- <li><a href="#prices">Prices</a></li> -->
          <li><a href="#services">Services</a></li>
        </ul>
      </nav><!-- .navbar -->

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
      <div class="row justify-content-between gy-5">
        <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2 data-aos="fade-up">Menully,<br>Digital QR Menu</h2>
          <p data-aos="fade-up" data-aos-delay="100">
            Say goodbye to outdated and PDF menus. Upgrade to the world's first QR digital menu. Generate unlimited QR codes. Exhibit the specific price associated with different seating options. Showcase your best-selling product and special offers/combos at the top of the menu.
          </p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <!-- <a href="google-log-in/login.php" class="btn-book-a-table">Create QR Menu</a> -->
            <a href="#about" class="btn-book-a-table">Get Started</a>
          </div>
        </div>
        <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
          <img src="pages/templates/source/img/hero-img.png" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <p>Menully, Digital QR Menu</p>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <img src="pages/templates/source/img/about.jpg" style="width:100%">
          </div>
          <div class="col-lg-6">
            <div style="padding:40px;">
              <p>
              Our menu service includes a whole range of functions for the restaurant, cafe or bar.
              </p> <p>
              For your guests - this is a modern, easy to use QR code menu.
              </p> <p>
              For you - this is an digital platform built around your QR code menu for improving a quality of customer service and increasing sales.
              </p> <p>
              No purchasing expensive terminals for you and no application installation on your guests phones needed for our digital menu to work.
              </p>
            </div>
          </div>
        </div>


      </div>
    </section><!-- End About Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="benefits" class="why-us section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <p>Menully, Digital QR Menu <span>benefits</span></p>
        </div>

        <div class="row gy-4">


          <div class="col-lg-12 d-flex align-items-center">
            <div class="row gy-4">

              <div class="col-xl-6" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-1-square"></i>
                  <h4>Enhancing Customer Experience</h4>
                  <p>Working with digital menu is easier. Loading of the menu is faster. There is more useful information in digital menu.</p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-2-square"></i>
                  <h4>Attracting new customers</h4>
                  <p>Guests are able to leave their reviews directly from the QR code menu. The more reviews - the more new guests are coming from reviews.</p>
                  <p>Convenient menu language switch - more guests-foreigners.</p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-xl-6" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-3-square"></i>
                  <h4>QR code menu increases sales</h4>
                  <p>Digital QR code menu sells more. Photos increase the appetite - the appetite increases the average check.</p>
                  <p>Making an order becomes easier. Less time to wonder, more spontaneous purchases - higher average check.</p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-xl-6" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-4-square"></i>
                  <h4>Saving business resources</h4>
                  <p>Our QR code menu is easy to edit. Higher relevance of the menu, less time and money spent on updating the menu.</p>
                  <p>Our QR menu works right away. No need to install applications, buy terminals, wait for confirmation etc.</p>
                </div>
              </div><!-- End Icon Box -->

            </div>
          </div>

        </div>

      </div>
    </section><!-- End Why Us Section -->


    <section id="prices" class="why-us section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <p>Menully, Digital QR Menu <span>Service Price</span></p>
        </div>

        <div class="row gy-4">


              <!-- <div class="col-xl-4" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <h4>If Paid Monthly </h4>
                  <h1>₱300</h1>
                  <p>Charged every month. <br> Total amount is ₱300</p>
                </div>
              </div>

              <div class="col-xl-4" data-aos="fade-up" data-aos-delay="200">
                <div style="background:red;color:white" class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <h4>If Paid Every 6 Months </h4>
                  <h1>₱250</h1>
                  <p style="color:white">Charged every 6 months. <br> Total amount is ₱1,500</p>
                </div>
              </div>

              <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <h4>If Paid Annually </h4>
                  <h1>200</h1>
                  <p>Charged every 12 months. <br> Total amount is ₱2,400</p>
                </div>
              </div> -->

              <div class="col-xl-12" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <h4>Free QR code menu for a month</h4>
                  <p>You can try our QR code menu service first, and then decide does it suits you or not. It's free and we do not ask for your credit card details.</p>

                    <a href="pages/store-sign-up.php" class="btn btn-primary">Try it for free</a>
                </div>
              </div>


        </div>


      </div>
    </section><!-- End Why Us Section -->



    <!-- ======= Menu Section ======= -->
    <section id="services" class="menu">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <p>Menully, Digital QR Menu <span>service includes</span></p>
        </div>

        <div class="row gy-5" style="margin:30px;">

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            An access to your menu by the link (for social networks, your website or google maps)
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            An access to your menu by QR code (for placement on tables, windows, showcases, doors etc.)
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            QR code menu with unlimited amount of categories and items
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            Both a mobile and a desktop version of the menu
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            Unlimited amount of viewings for your menu
          </div>
          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            An ability to remotely edit your menu
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            An ability to add employees to manage your menu
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            An ability to add several places into your profile, to easily manage a chain of restaurants
          </div>


          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            An ability to hide menu positions with one click
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            "Temporary unavailable" feature
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            "Old price/New Price" feature
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            An ability to create a multi language QR code menu
          </div>
          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            Unlimited photos and description loading for your QR code menu
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            Additional restaurant information feature (Address, Phone number, Map, Wi-Fi password)
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            QR code generator for your menu
          </div>

          <div class="col-lg-6">
            <i class="bi bi-balloon-fill"></i>
            Unlimited number of QR code scans
          </div>
        </div>


      </div>
    </section><!-- End Menu Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Menully, Digital QR Menu</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://fredoware.com/" target="_blank">Fredoware Software Solutions</a>
      </div>
    </div>

  </footer><!-- End Footer -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="pages/templates/source/bootstrap.bundle.min.js"></script>
  <script src="pages/templates/source/aos.js"></script>
  <script src="pages/templates/source/glightbox.min.js"></script>
  <script src="pages/templates/source/purecounter_vanilla.js"></script>
  <script src="pages/templates/source/swiper-bundle.min.js"></script>
  <script src="pages/templates/source/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="pages/templates/source/main.js"></script>

</body>
</html>
