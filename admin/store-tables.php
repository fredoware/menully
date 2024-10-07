<?php
include "templates/header.php";

$Id = $_GET['Id'];
$store = store()->get("Id=$Id");

$tableList = storeTable()->list("storeId=$Id and isDeleted=0");


?>

<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">

            <div class="col-2 mih-left">

                <button class="btn btn-warning" onclick="history.back()"><i class="bi bi-arrow-left"></i></button>
            </div>
            <div class="col-9">
                <h4 class="fw-semibold mb-8">QR Tables for <?=$store->storeCode;?></h4>
            </div>
        </div>
    </div>
</div>


<button class="btn btn-primary" id="btn-add-category">Add QR Table +</button>


<main id="main">

  <section id="menu" class="menu">
    <div class="container" data-aos="fade-up">



      <div class="modal fade" id="formItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">QR Table Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="process.php?action=table-save" method="post" enctype="multipart/form-data">
              <input type="hidden" name="Id" id="input-Id">
              <input type="hidden" name="storeId" value="<?=$Id?>">
              Table Name:
              <input type="text" name="name" id="input-name" class="form-control" required>

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
      <?php foreach ($tableList as $row): ?>
        <div class="col-lg-4 mt-2">
        <div class="card item-items">
              <div class="card-body item-data"
                  data-id="<?=$row->Id;?>"
                  data-name="<?=$row->name;?>"
              >
              <div id="qrcode-<?=$row->Id?>" class="text-center"></div>
              <h5 class="text-center mt-3"><?=$row->name?></h5>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-warning edit">Edit</a>
              <button class="btn btn-danger" onclick="deleteNotification('process.php?action=table-delete&tableId=<?=$row->Id?>&storeId=<?=$Id?>')">Delete</button>
            </div>
          </div>
        </div>
        <script>
          var qrcode = new QRCode(document.getElementById("qrcode-<?=$row->Id?>"), {
            text: "https://menully.com/<?=$store->storeCode;?>/?tblno=<?=$row->Id?>",
            width: 300,
            height: 300,
            colorDark: "#000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        </script>
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

        $("#formItemModal").modal("show");
      });
    }

    editContact();

  });

</script>
