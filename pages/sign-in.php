<?php
  include "templates/header.php";

?>
<div class="row" style="justify-content: center; margin:10px;">
  <div class="col-lg-4" style="margin-top:100px;padding:10px;">
    <div class="card">
      <div class="card-header text-center">
        <b>Sign in</b>
      </div>
      <div class="card-body">
        <form class="" action="process.php?action=store-log-in" method="post">
          <b>Store Code</b>
          <input type="text" name="storeCode" autofocus class="form-control mb-3" required/>
          <b>password</b>
          <input type="password" name="password" class="form-control mb-3" required/>
          <button type="submit" class="btn btn-primary">Log In</button>
        </form>
      </div>
    </div>
  </div>
</div>



<?php include "templates/footer.php"; ?>
