<?php
  $ROOT_DIR="../";
  include "templates/header.php";
  $user_list = user()->list();
  $password = rand_string(6);; //the number specified in brackets is the amount of characters in your password

?>


<h1>Users</h1>
<a type="button" class="btn btn-warning" href="javascript:void(0)" id="btn-add-user">Add User</a>

<div class="modal fade" id="formItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">User Form</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form action="process.php?action=user-save" method="post">
        <input type="hidden" name="Id" id="input-Id">
        Firstname:
        <input type="text" name="firstName" id="input-firstName" class="form-control clear" required>
        Lastname:
        <input type="text" name="lastName" id="input-lastName" class="form-control clear" required>
        Username:
        <input type="text" name="username" id="input-username" class="form-control clear" required>
        Password:
        <input type="text" name="password" id="input-password"  class="form-control" value="<?=$password?>"required>
        <br>
        <label for="role">Role:</label>
        <select name="role" id="input-role">
          <option value="Admin">Admin</option>
          <option value="Manager">Manager</option>
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


  <table class="table">
    <th>#</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Username</th>
    <th>Role</th>
    <th>Actions</th>

    <!-- End modal Add -->

    <?php
    $count = 0;
    foreach ($user_list as $row):
    $count += 1;
    ?>

      <tr class="item-items">
        <td class="item-data"

          data-id="<?=$row->Id;?>"
          data-firstName="<?=$row->firstName;?>"
          data-lastName="<?=$row->lastName;?>"
          data-username="<?=$row->username;?>"
          data-password="<?=$row->password;?>"
          data-role="<?=$row->role;?>">


          <?=$count?></td>
          <td><?=$row->firstName?></td>
          <td><?=$row->lastName?></td>
          <td><?=$row->username?></td>
          <td><?=$row->role?></td>


          <td>  <a href="javascript:void(0)" class="btn btn-warning edit">Edit</a>
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
              <a href="process.php?action=delete-user&Id=<?=$row->Id?>" class="btn btn-danger">Delete</a>
            </div>
          </div>
        </div>
      </div>
      <!-- End Delete Modal -->

<?php endforeach; ?>

</table>
</div>

<script type="text/javascript">

$(function() {

    $("#btn-add-user").on("click", function (event) {
      $("#formItemModal #btn-add").show();
      $("#formItemModal #btn-edit").hide();
      $('.clear').val('');
      $('#input-password').val('<?=$password?>');
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
        getModal.find("#input-firstName").val($_name.attr("data-firstName"));
        getModal.find("#input-lastName").val($_name.attr("data-lastName"));
        getModal.find("#input-username").val($_name.attr("data-username"));
        getModal.find("#input-password").val($_name.attr("data-password"));

        $("#formItemModal").modal("show");
      });
    }

    editContact();


  });

</script>




<?php include $ROOT_DIR . "../templates/footer.php"; ?>
