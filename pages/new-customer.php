<?php
include "templates/header-blank.php";

?>


<!-- Cart Page Start -->
<div class="container-fluid py-5">


  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                  <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                  <div class="card-body">
                    <span style="color:red;"><?=$error;?></span>
                    <span style="color:green;"><?=$success;?></span>
                      <form method="post" action="../pages/process.php?action=new-customer">
                        <input type="hidden" name="storeCode" value="<?=$storeCode?>">
                          <div class="form-floating mb-3">
                              <input class="form-control" name="name" type="text" placeholder="User Name" required />
                              <label for="inputUsername">Name</label>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                              <button type="submit" class="btn btn-primary">Continue</button>
                          </div>
                          <br>

                          <!-- <a href="signup.php">Not a member yet? Sign up here</a> -->
                      </form>
                  </div>
                  <div class="card-footer text-center py-3">
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

  <?php
  include "templates/footer.php";

  ?>
