<?php
include "templates/header.php";

$Id = $_GET['Id'];

$category_list = menuCategory()->list("storeId=$Id order by priority");


?>



<div class="card bg-light-info shadow-none position-relative overflow-hidden">
<div class="card-body px-4 py-3">
    <div class="row align-items-center">
    <div class="col-9">
        <h4 class="fw-semibold mb-8">Categories</h4>
    </div>
    <div class="col-3">
        <div class="text-center mb-n5">
        <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
        </div>
    </div>
    </div>
</div>
</div>


<button class="btn btn-primary" id="btn-add-category">Add New Category +</button>


<main id="main">

  <section id="menu" class="menu">
    <div class="container" data-aos="fade-up">



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
              <input type="hidden" name="storeId" value="<?=$Id?>">
              Name:
              <input type="text" name="name" id="input-name" class="form-control" required>
              Description:
              <input type="text" name="description" id="input-description" class="form-control" required>

              Image:
              <input type="file" class="form-control" id="input-image" name="image">

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
      <?php foreach ($category_list as $row): ?>
        <div class="col-lg-4 mt-2">
          <div class="card clickable">
            <div class="card-body text-center">
            <img src="../media/<?=$row->image?>" class="crop-box">
              <h5><?=$row->name?></h5>
              <p><i><?=$row->description?></i></p>
            </div>
            <div class="card-footer">
              <a href="store-menu-item.php?Id=<?=$row->Id?>&storeId=<?=$Id?>" class="btn btn-primary">View</a>
              <a href="#" class="btn btn-warning">Edit</a>
              <a href="#" class="btn btn-danger">Delete</a>
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
