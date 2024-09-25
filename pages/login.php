<?php
include "templates/header.php";

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
                      <form method="post" action="../pages/processAuth.php?action=user-login">
                        <input type="hidden" name="storeCode" value="<?=$storeCode?>">
                          <div class="form-floating mb-3">
                              <input class="form-control" id="inputUsername" name="username" type="text" placeholder="User Name" />
                              <label for="inputUsername">Email</label>
                          </div>
                          <div class="form-floating mb-3">
                              <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                              <label for="inputPassword">Password</label>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                              <button type="submit" class="btn btn-primary">Login</button>
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
