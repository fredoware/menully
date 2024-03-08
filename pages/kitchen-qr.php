<?php
  include "templates/header-store.php";

?>


<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
      <div class="row justify-content-between gy-5">
        <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2 data-aos="fade-up"><?=$store->name?><br>Menu QR Code</h2>
        </div>
        <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
          <center>
            <div id="qrcode-2"></div>
          </center>
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->



  <script type="text/javascript">
  var qrcode = new QRCode(document.getElementById("qrcode-2"), {
  	text: "https://qr-menu.fredoware.com/check-in.php?store=<?=$storeName;?>",
  	width: 300,
  	height: 300,
  	colorDark : "#000",
  	colorLight : "#ffffff",
  	correctLevel : QRCode.CorrectLevel.H
  });
  </script>
<?php include "templates/footer.php"; ?>
