<?php
  $ROOT_DIR="../";
  include "templates/header.php";
  $store_count = store()->count();
  ?>
  <div class="row">
    <div class="col-4">
      <div class="card">
        <div class="card-header text-center text-white bg-dark">
          NUMBER OF STORES
        </div>
        <div class="card-body text-center">
        <h1>  <?=$store_count?><h1>
        </div>
        <div class="card-footer text-center">
          <a href="store.php" class="btn btn-info">Show Store</a>
        </div>
      </div>
    </div>

    <div class="col-4">
      <div class="card">
        <div class="card-header text-center text-white bg-dark">
          SERVICE PLANS
        </div>
      </div>
    </div>

    <div class="col-4">
      <div class="card">
        <div class="card-header text-center text-white bg-dark">
          PACKAGES
        </div>
      </div>
    </div>
  </div>


<?php include "templates/footer.php"; ?>
