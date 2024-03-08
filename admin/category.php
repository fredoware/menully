<?php
  $ROOT_DIR="../";
  include "templates/store-header.php";
  $store = store()->get("Id=$storeId");
  $category_list = menuCategory()->list("storeId=$store->Id");

?>

<h1>Menu Category</h1>

<a type="button" class="btn btn-warning" href="javascript:void(0)" id="btn-add-category">Add Category</a>

<div class="modal fade" id="formItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Category Form</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form action="process.php?action=category-save" method="post" enctype="multipart/form-data">
        <input type="hidden" name="Id" id="input-Id">
        <input type="hidden" name="storeId" value="<?=$store->Id?>">
        Name:
        <input type="text" name="name" id="input-name" class="form-control" required>
        Description:
        <input type="text" name="description" id="input-description" class="form-control" required>

        Image:
        <input type="file" class="form-control" id="input-image" name="image" required>

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
    <th>Image</th>
    <th>Name</th>
    <th>Action</th>

    <!-- End modal Add -->

    <?php foreach ($category_list as $row): ?>
      <tr class="item-items">
        <td class="item-data"
            data-id="<?=$row->Id;?>"
            data-name="<?=$row->name;?>"
            data-description="<?=$row->description;?>">

    <img src="../media/<?=$row->image?>" style="width:40px; height:40px; border-radius:50%;"></td>
        <td><?=$row->name?></td>

        <td>
          <a href="menu-item.php?Id=<?=$row->Id?>" class="btn btn-info">View</a>
          <a href="javascript:void(0)" class="btn btn-warning edit">Edit</a>
         <a href=""  data-bs-toggle="modal" data-bs-target="#deleteItem<?=$row->Id?>" class="btn btn-danger" >Delete</a> </td>

      </tr>

<!-- Modal -->
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
        <a href="process.php?action=category-delete&Id=<?=$row->Id?>" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<?php endforeach; ?>
</table>
</div>


<?php include "templates/footer.php"; ?>

<script type="text/javascript">
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
