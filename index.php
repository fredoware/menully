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
    <meta property="og:image" content="https://menully.com/website/source/img/open-graph.jpg" />

    <!-- Favicons -->
    <link href="website/source/img/favicon.png" rel="icon">
    <link href="website/source/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="website/source/bootstrap.min.css" rel="stylesheet">
    <link href="website/source/bootstrap-icons.css" rel="stylesheet">
    <link href="website/source/aos.css" rel="stylesheet">
    <link href="website/source/glightbox.min.css" rel="stylesheet">
    <link href="website/source/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="website/source/main.css" rel="stylesheet">

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
                <img src="website/source/img/logo.png" style="margin-right:15px;">
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
                <div
                    class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
                    <h2 data-aos="fade-up">Menully,<br>Digital QR Menu</h2>
                    <p data-aos="fade-up" data-aos-delay="100">
                        Say goodbye to outdated and PDF menus. Upgrade to the world's first QR digital menu. Generate
                        unlimited QR codes. Exhibit the specific price associated with different seating options.
                        Showcase your best-selling product and special offers/combos at the top of the menu.
                    </p>
                    <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                        <!-- <a href="google-log-in/login.php" class="btn-book-a-table">Create QR Menu</a> -->
                        <a href="#about" class="btn-book-a-table">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
                    <img src="website/source/img/hero-img.png" class="img-fluid" alt="" data-aos="zoom-out"
                        data-aos-delay="300">
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
                        <img src="website/source/img/about.jpg" style="width:100%">
                    </div>
                    <div class="col-lg-6">
                        <div style="padding:40px;">


                            <p>Our menu service offers a comprehensive solution for restaurants, cafés, and bars.</p>
                            <p>

                                For your guests, it’s a modern, user-friendly digital menu accessed easily through a QR
                                code.
                            </p>
                            <p>

                                For you, it’s a powerful platform designed to enhance customer service and boost
                                sales—all centered around your QR code menu.
                            </p>
                            <p>

                                No need to invest in costly hardware, and your customers don’t have to download any
                                apps. Our digital menu works seamlessly right from their smartphones.
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
                                    <h4>Elevate the Customer Experience</h4>
                                    <p>A digital menu is faster, easier, and packed with more valuable information. No more waiting—your guests can browse, order, and enjoy with just a quick scan.</p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-2-square"></i>
                                    <h4>Attract More Customers</h4>
                                    <p>Guests can leave reviews directly from the menu, driving more feedback and attracting new visitors through word of mouth.
                                    </p>
                                    <p>With a simple language switch option, you can cater to international guests, making your restaurant more appealing to a wider audience.</p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-3-square"></i>
                                    <h4>Boost Your Sales</h4>
                                    <p>A digital menu with vibrant photos tempts guests to order more, increasing appetite and boosting the average check.</p>
                                    <p>Simplifying the ordering process leads to quicker decisions, more impulse purchases, and ultimately, higher sales.</p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-4-square"></i>
                                    <h4>Save Time and Resources</h4>
                                    <p>Easily update your menu in real time, ensuring it's always relevant without the cost and hassle of reprinting.</p>
                                    <p>Our QR menu is ready to use instantly—no need for apps, terminals, or waiting for approval. Just scan, and it works!.</p>
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


                    <div class="col-xl-12" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                            <h4>Free QR code menu for 14 days</h4>
                            <p>Experience our QR code menu service risk-free! Try it out with no commitment—no credit card required. You decide if it’s the right fit for your business.</p>

                            <a href="" class="btn-book-a-table">Try it for free</a>
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
                        <B>Instant Access Anywhere</B> Share your menu via a direct link for use on social media, your website, or Google Maps.
                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Custom QR Code Access</B> Create unique QR codes to place on tables, windows, doors—anywhere your guests can scan.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Unlimited Menu Options</B> Add as many categories and items as you need, with no limits on what you can showcase.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Mobile & Desktop Ready</B> Your menu is fully optimized for both mobile and desktop, ensuring easy access from any device.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Unlimited Views</B> There’s no cap on how many people can view your menu—reach as many guests as possible.

                    </div>
                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Remote Menu Editing</B> Update your menu anytime, from anywhere, with just a few clicks.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Team Collaboration</B> Add staff members to manage and update your menu efficiently.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Multi-Location Management</B> Seamlessly manage multiple restaurant locations from one account.

                    </div>


                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Instant Item Control</B> Hide or update items in real-time with a single click.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>"Temporary Unavailable" Feature</B> Easily mark items that are out of stock without removing them permanently.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Price Management</B> Showcase both the old and new prices of menu items to highlight deals or changes.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Multi-Language Support</B> Create a multilingual menu to cater to all your guests, no matter where they're from.

                    </div>
                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Rich Media Integration</B> Upload unlimited photos and detailed descriptions to make your dishes more enticing.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Extra Info at a Glance</B> Include essential details like your address, phone number, map, and even Wi-Fi password.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Custom QR Code Generator</B> Create as many QR codes as you need to make your menu easily accessible.

                    </div>

                    <div class="col-lg-6">
                        <i class="bi bi-balloon-fill"></i>
                        <B>Unlimited Scans</B> Enjoy limitless QR code scans—there’s no restriction on how often customers can use them.

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

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="website/source/bootstrap.bundle.min.js"></script>
    <script src="website/source/aos.js"></script>
    <script src="website/source/glightbox.min.js"></script>
    <script src="website/source/purecounter_vanilla.js"></script>
    <script src="website/source/swiper-bundle.min.js"></script>
    <script src="website/source/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="website/source/main.js"></script>

</body>

</html>