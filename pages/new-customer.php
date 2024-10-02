<?php
include "templates/header-blank.php";

?>


<!-- Cart Page Start -->
<div class="container-fluid py-5">


  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-5 text-center">
                <img src="../media/<?=$store->logo?>" width="50%">
              <form method="get" action="../pages/process.php">
              <input type="hidden" name="action" value="new-customer">
              <input type="hidden" name="storeCode" value="<?=$storeCode?>">
                    <div class="form-floating mb-3 mt-3">
                        <input class="form-control" name="name" autocomplete="off" type="text" placeholder="User Name" required />
                        <label for="inputUsername">Nick Name</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                    <br>

                    <!-- <a href="signup.php">Not a member yet? Sign up here</a> -->
                </form>
          </div>
      </div>
  </div>
</div>

  <?php
  include "templates/footer.php";

  ?>
