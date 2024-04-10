<?php
  include "../pages/templates/header.php";

  $cart = $_SESSION["cart"];

  $totalAmount = 0;
  $totalQuantity = 0;

  foreach ($cart as $key => $qty){
    $item = menuItem()->get("Id=$key");
    $totalAmount += $item->price*$qty;
    $totalQuantity += $qty;
  }

?>


  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
      <div class="row justify-content-between gy-5">
        <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2 data-aos="fade-up"><?=$store->name?><br>Menu Book</h2>
          <a href="" data-bs-toggle="modal" data-bs-target="#menuCategory" class="btn-book-a-table">Check our menu</a>
        </div>
        <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
          <img src="../media/<?=$store->logo?>" class="img-fluid" alt="" data-aos="zoom-out" style="width:50%;" data-aos-delay="300">
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->


<?php include "templates/footer.php"; ?>
