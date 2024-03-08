<?php
  include "templates/header-blank.php";

?>
<style media="screen">
  .form-control{
    margin-bottom:10px;
  }
</style>


<div class="row" style="justify-content: center; margin:10px;">
  <div class="col-lg-4" style="margin-top:100px;padding:10px;">
    <div class="card">
      <div class="card-header text-center">
        <b>Sign Up</b>
      </div>
      <div class="card-body">
        <form class="" action="process.php?action=store-sign-up" method="post">
          Store Name:
          <input type="text" name="name" id="input-storeName" onkeyup="generate_store_code()" class="form-control" required>
          Store Code:
          <input type="text" name="storeCode" id="input-storeCode" class="form-control" required>
          Owner:
          <input type="text" name="owner" class="form-control" required>
          Phonenumber:
          <input type="text" name="phone" class="form-control" required>
          Address:
          <input type="text" name="address" class="form-control" required>
          Email Address:
          <input type="text" name="email" class="form-control" required>
          Theme:
          <input type="text" name="theme" class="form-control" required>
          Password:
          <input type="text" name="password" class="form-control" required>
          Logo:
          <input type="file" class="form-control" name="logo" required>
          <button type="submit" class="btn btn-primary mt-5">Sign Up</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function generate_store_code(){
    var storeName = document.getElementById("input-storeName");
    var storeCode = document.getElementById("input-storeCode");
    
    var strLower = storeName.value.toLowerCase();

    storeCode.value = strLower.replace(/\s/g, '');

  }
</script>


<?php include "templates/footer.php"; ?>
