<?php
  include "templates/header-blank.php";

  if (isset($_SESSION['login_id'])) {
  	  $userGoogleId = $_SESSION['login_id'];
  	  $user = user()->get("google_id='$userGoogleId'");
  }
  else{
    header("Location: ../google-log-in/login.php");
  }

?>
<style media="screen">
.form-control {
    margin-bottom: 10px;
}
</style>

<div class="row" style="justify-content: center; margin:10px;">
    <div class="col-lg-12" style="margin-top:50px;padding:10px;">
        <div class="card">
            <div class="card-header text-center">
                <h4>Create a Store</h4>
            </div>
            <div class="card-body">
                <form class="" action="process.php?action=store-sign-up" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            Store Name:
                            <input type="text" name="name" id="input-storeName" onkeyup="generate_store_code()"
                                class="form-control" required>
                            Store Code:
                            <i id="store-code-error"></i>
                            <input type="text" name="storeCode" id="input-storeCode" onkeyup="store_code_validity()"
                                class="form-control" required>
                            Owner:
                            <input type="hidden" name="ownerId" value="<?=$user->Id?>" required>
                            <input type="text" name="owner" class="form-control" value="<?=$user->name?>" disabled>
                            Phone Number:
                            <input type="text" name="phone" class="form-control" required>
                            Address:
                            <input type="text" name="address" class="form-control" required>
                            Email Address:
                            <input type="text" name="email" class="form-control" value="<?=$user->email?>" disabled>
                        </div>
                        <div class="col-lg-6">

                            <label for="fileInput">
                                <img id="logo" src="templates/source/img/default-store-logo.jpg" style="width:100%;">
                            </label>
                            <input id="fileInput" type="file" name="logo" accept="image/*" onchange="loadFile(event)"
                                required style="display:none">
                            <br>
                            <button type="submit" class="btn btn-primary mt-5">Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
var loadFile = function(event) {
    var output = document.getElementById('logo');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
};

var storeName = document.getElementById("input-storeName");
var storeCode = document.getElementById("input-storeCode");
var storeCodeError = document.getElementById("store-code-error");

function generate_store_code() {

    var strLower = storeName.value.toLowerCase();

    storeCode.value = strLower.replace(/\s/g, '');

    store_code_validity();

}

function store_code_validity() {
    $.ajax({
        type: "GET",
        url: "api-check-store-code-exist.php?storeCode=" + storeCode.value,
        success: function(data) {
            const obj = JSON.parse(data);
            if (obj.result > 0) {
                storeCodeError.innerHTML = "Store Code Not Available";
                storeCodeError.style.color = "red";
                storeCode.setCustomValidity("Store Code Already Exists");
            } else {
                storeCodeError.innerHTML = "Store Code Available";
                storeCodeError.style.color = "green";
                storeCode.setCustomValidity("");
            }
        }
    });
}
</script>


<?php include "templates/footer.php"; ?>