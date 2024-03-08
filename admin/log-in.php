<?php
  $ROOT_DIR="../";
  include "templates/header0.php";
  ?>
  <div class="card text-center mt-5" style="width:30%;">
  <div class="card-header text-white bg-dark ">
    <h2>MENUBOOK</h2>
  </div>
  <div class="card-body text-center">
    <form action="process.php?action=log-in" method="post">
      <h5>Username</h5>
      <input type="text" name="username" class="form-control" >
      <h5>Password</h5>
      <input type="password" name="password" class="form-control">
      <br>
  </div>
  <div class="card-footer bg-dark">
    <button type="submit" name="button" class="btn btn-primary" style="width: 20%;">Login</button>
    </form>
  </div>
</div>



<?php include $ROOT_DIR . "../templates/footer.php"; ?>
