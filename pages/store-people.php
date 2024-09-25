<?php
  include "templates/header-store.php";

  $people_list = storePeople()->list("storeId=$store->Id");

?>

<main id="main">

  <section id="menu" class="menu">
    <div class="container">

      <div class="menu-item-header">
        <div class="row">
          <div class="col-2 mih-left" onclick="location.href='store-main.php'">
            <i class="bi bi-arrow-left"></i>
          </div>
          <div class="col mih-center">
              <h6>People</h6>
          </div>
          <div class="col-2 mih-right" data-bs-toggle="modal" data-bs-target="#menuCategory">
            <a type="button" href="javascript:void(0)" id="btn-add-category"><i class="bi bi-plus-circle-fill"></i></a>
          </div>
        </div>
      </div>


      <div class="modal fade" id="formItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Role Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="process.php?action=people-add" method="post" enctype="multipart/form-data">
              <input type="hidden" name="Id" id="input-Id">
              <input type="hidden" name="storeId" value="<?=$store->Id?>">
              Name/Email:
              <i id="username-error"></i>
              <input type="text" name="username" id="input-username" onkeyup="username_validity()" class="form-control" required>
              Role:
              <select class="form-control" name="role" required>
                <option value="">--Select--</option>
                <option>Admin</option>
                <option>Staff</option>
              </select>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button name="form-type" value="add" id="btn-add" class="btn btn-primary">Add</button>
            <button name="form-type" value="edit" id="btn-edit" class="btn btn-warning">Save</button>
          </div>
        </div>
      </div>
      </div>



      <div class="row mt-3">
      <?php foreach ($people_list as $row):
        $people = user()->get("Id=$row->userId");
        ?>
        <div class="col-lg-4 mt-2">
          <div class="card clickable">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5><?=$people->name?></h5>
                  <i>(<?=$row->role?>)</i>
                </div>
                <?php if ($user->Id!=$people->Id): ?>
                  <div class="col-4 text-right mt-2">
                    <a href="process.php?action=delete-people&Id=<?=$row->Id?>" class="btn btn-danger">Delete</a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      </div>



      </div>
    </section><!-- End Menu Section -->

</main>



<?php include "templates/footer.php"; ?>


<script type="text/javascript">

var username = document.getElementById("input-username");
var usernameError = document.getElementById("username-error");

function username_validity(){
  $.ajax({
      type: "GET",
      url: "../pages/api-check-username-exist.php?username=" + username.value,
      success: function(data){
        const obj = JSON.parse(data);
        if (obj.result>0) {
          usernameError.innerHTML = "Username is valid";
          usernameError.style.color = "green";
          username.setCustomValidity("");
        }
        else{
          usernameError.innerHTML = "Username not exist";
          usernameError.style.color = "red";
          username.setCustomValidity("Username not exist");
        }
      }
    });
}

$(function () {

    $("#btn-add-category").on("click", function (event) {

      $("#formItemModal #btn-add").show();
      $("#formItemModal #btn-edit").hide();
      $(".form-control").val('');
      $("#formItemModal").modal("show");
    });

    function editContact() {
      $(".edit").on("click", function (event) {

        $("#formItemModal #btn-add").hide();
        $("#formItemModal #btn-edit").show();

        var getParentItem = $(this).parents(".item-items");
        var getModal = $("#formItemModal");

        // Get List Item Fields
        var $_name = getParentItem.find(".item-data");

        // Set Modal Field's Value
        getModal.find("#input-id").val($_name.attr("data-id"));
        getModal.find("#input-name").val($_name.attr("data-name"));
        getModal.find("#input-description").val($_name.attr("data-description"));
        getModal.find("#input-image").attr("required", false);

        $("#formItemModal").modal("show");
      });
    }

    editContact();

  });

</script>
