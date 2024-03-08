<?php
  $ROOT_DIR="../";
  include "templates/header.php";
  $store_list = store()->list();
  $password = rand_string(6); //the number specified in brackets is the amount of characters in your password

?>


<h1>Store</h1>


<a type="button" class="btn btn-warning" href="javascript:void(0)" id="btn-add-store">Add Store</a>

<div class="modal fade" id="formItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Store Form</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form action="process.php?action=store-save" method="post" enctype="multipart/form-data">
        <input type="hidden" name="Id" id="input-Id">
        Store Code:
        <input type="text" name="storeCode" id="input-storeCode" class="form-control" required>
        Storename:
        <input type="text" name="name" id="input-name" class="form-control" required>
        Owner:
        <input type="text" name="owner" id="input-owner" class="form-control" required>
        Phonenumber:
        <input type="text" name="phone" id="input-phone" class="form-control" required>
        Address:
        <input type="text" name="address" id="input-address" class="form-control" required>
        Email Address:
        <input type="text" name="email" id="input-email" class="form-control" required>
        Theme:
        <input type="text" name="theme" id="input-theme" class="form-control" required>
        Password:
        <input type="text" name="password" id="input-password" class="form-control" required>
        <br>
        Logo:
        <input type="file" class="form-control" id="input-logo" name="logo" required>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button name="form-type" value="add" id="btn-add" class="btn btn-primary">Add</button>
      <button name="form-type" value="edit" id="btn-edit" class="btn btn-warning">Save</button>
    </div>
  </div>
</div>
</div>


  <table class="table">
    <th>Logo</th>
    <th>Store</th>
    <th>Owner</th>
    <th>Action</th>

    <!-- End modal Add -->

    <?php foreach ($store_list as $row): ?>
      <tr class="item-items">
        <td class="item-data"
            data-id="<?=$row->Id;?>"
            data-storeCode="<?=$row->storeCode;?>"
            data-name="<?=$row->name;?>"
            data-owner="<?=$row->owner;?>"
            data-phone="<?=$row->phone;?>"
            data-address="<?=$row->address;?>"
            data-email="<?=$row->email;?>"
            data-theme="<?=$row->theme;?>">

    <img src="../media/<?=$row->logo?>" style="width:40px; height:40px; border-radius:50%;"></td>
        <td><?=$row->name?></td>
        <td><?=$row->owner?></td>


        <td>
          <a href="process.php?action=view-store&Id=<?=$row->Id?>" class="btn btn-info">View Store</a>
          <a href="javascript:void(0)" class="btn btn-warning edit">Edit</a>
          <a href="" data-bs-toggle="modal" data-bs-target="#deleteItem<?=$row->Id?>" class="btn btn-danger" >Delete</a> </td>
      </tr>

      <!-- Delete Modal -->
      <div class="modal fade" id="deleteItem<?=$row->Id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Warning</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete this?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <a href="process.php?action=delete-store&Id=<?=$row->Id?>" class="btn btn-danger">Delete</a>
            </div>
          </div>
        </div>
      </div>
      <!-- End Delete Modal -->

<?php endforeach; ?>
</table>
</div>


<?php include "templates/footer.php"; ?>

<script type="text/javascript">
$(function () {

    $("#btn-add-store").on("click", function (event) {

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
        getModal.find("#input-storeCode").val($_name.attr("data-storeCode"));
        getModal.find("#input-name").val($_name.attr("data-name"));
        getModal.find("#input-owner").val($_name.attr("data-owner"));
        getModal.find("#input-phone").val($_name.attr("data-phone"));
        getModal.find("#input-address").val($_name.attr("data-address"));
        getModal.find("#input-email").val($_name.attr("data-email"));
        getModal.find("#input-theme").val($_name.attr("data-theme"));
        getModal.find("#input-password").attr("disabled", true);
        getModal.find("#input-password").val("Not Shown for security");
        getModal.find("#input-logo").attr("required", false);

        $("#formItemModal").modal("show");
      });
    }

    editContact();

  });

</script>
