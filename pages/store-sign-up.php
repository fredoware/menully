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
        <h4>Create Store</h4> <br>
        <a href="sign-in.php">Already have an account? Log in here</a>
      </div>
      <div class="card-body">
        <form class="" action="process.php?action=store-sign-up" enctype="multipart/form-data" method="post">
          Store Name:
          <input type="text" name="name" id="input-storeName" onkeyup="generate_store_code()" class="form-control" required>
          Store Code:
          <i id="store-code-error"></i>
          <input type="text" name="storeCode" id="input-storeCode" onkeyup="store_code_validity()" class="form-control" required>
          Owner:
          <input type="text" name="owner" class="form-control" required>
          Phone Number:
          <input type="text" name="phone" class="form-control" required>
          Address:
          <input type="text" name="address" class="form-control" required>
          Email Address:
          <input type="text" name="email" class="form-control" required>
          Password:
          <input type="password" name="password" class="form-control" required>
          Logo:
          <input type="file" class="form-control" name="logo" required>
          <button type="submit" class="btn btn-primary mt-5">Sign Up</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

  var storeName = document.getElementById("input-storeName");
  var storeCode = document.getElementById("input-storeCode");
  var storeCodeError = document.getElementById("store-code-error");

  function generate_store_code(){

    var strLower = storeName.value.toLowerCase();

    storeCode.value = strLower.replace(/\s/g, '');

    store_code_validity();

  }

  function store_code_validity(){
    $.ajax({
        type: "GET",
        url: "api-check-store-code-exist.php?storeCode=" + storeCode.value,
        success: function(data){
          const obj = JSON.parse(data);
          if (obj.result>0) {
            storeCodeError.innerHTML = "Store Code Not Available";
            storeCodeError.style.color = "red";
            storeCode.setCustomValidity("Store Code Already Exists");
          }
          else{
            storeCodeError.innerHTML = "Store Code Available";
            storeCodeError.style.color = "green";
            storeCode.setCustomValidity("");
          }
        }
      });
  }
</script>


<?php include "templates/footer.php"; ?>
