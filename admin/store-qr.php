<?php
  $ROOT_DIR="../";
  include "templates/store-header.php";

?>


<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


<div class="card" style="width: 50%; margin-left: 200px;">
    <div class="card card-header bg-dark text-white text-center">
      PLEASE SCAN TO SEE THE MENU
    </div>
    <div class="card-body">
      <center>
        <img src="../media/<?=$store->logo?>" style="width:100px; height:100px; border-radius:50%; margin-bottom: 2px;">
        <br>
        <b><?=$store->name?></b>
        <div id="qrcode-2"></div>
      </center>
    </div>
    <div class="card-footer">
      <center>
      <button type="button" name="button" class="btn btn-info">PRINT</button>
        <center>
    </div>
</div>




  <!-- ======= Hero Section ======= -->

        <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">

        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->



  <script type="text/javascript">
  var qrcode = new QRCode(document.getElementById("qrcode-2"), {
  	text: "https://menully.com/check-in.php?store=<?=$store->name;?>",
  	width: 300,
  	height: 300,
  	colorDark : "#000",
  	colorLight : "#ffffff",
  	correctLevel : QRCode.CorrectLevel.H
  });
  </script>
