<?php
  include "templates/header-store.php";

  $status = get_query_string("status", "");


  $voucherList = voucher()->list("storeId=$store->Id");
  if ($status) {
    $voucherList = voucher()->list("status='$status' and storeId=$store->Id");
  }

  $activeAll = "";
  $activeActive = "";
  $activeInactive = "";

  if (!$status) {
    $activeAll = 'active';
  }
  if ($status=="Active") {
    $activeActive = 'active';
  }
  if ($status=="Inactive") {
    $activeInactive = 'active';
  }

?>

  <section>
    <div class="container">

      <div class="menu-item-header">
        <div class="row">
          <div class="col-2 mih-left" onclick="location.href='store-menu-category.php'">
            <i class="bi bi-arrow-left"></i>
          </div>
          <div class="col mih-center">
            <h6>Vourchers</h6>
          </div>
          <div class="col-2 mih-right" data-bs-toggle="modal" data-bs-target="#menuCategory">
            <a type="button" href="javascript:void(0)" id="btn-add-category"><i class="bi bi-plus-circle-fill"></i></a>
          </div>
        </div>
      </div>

      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link <?=$activeAll?>" href="store-vouchers.php">All</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=$activeActive?>" href="?status=Active">Active</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=$activeInactive?>" href="?status=Inactive">Inactive</a>
        </li>
      </ul>

      <div class="modal fade" id="formItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Voucher Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="process.php?action=voucher-save" method="post" enctype="multipart/form-data">
              <input type="hidden" name="Id" id="input-Id">
              <input type="hidden" name="storeId" value="<?=$store->Id?>">
              Voucher Type:
              <select id="voucherType" class="form-control" name="type" required>
                <option value="">--Select--</option>
                <option>Discount</option>
                <option>Gift</option>
              </select>

              <div id="voucher-label">
                Name:
              </div>
              <i id="discount-display" style="color:green"></i>
              <input type="number" id="input-discount" name="discount" class="form-control" required>
              <input type="text" name="name" id="input-name" class="form-control" required>

              Min Spend:
              <input type="number" name="minimumSpend" class="form-control" required>
              Quantity:
              <input type="number" name="maxQuantity" class="form-control" required>
              Valid Until:
              <input type="datetime-local" name="validUntil" class="form-control" required>
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



        <?php foreach ($voucherList as $row):
           ?>

            <div class="col-lg-4 mb-3">
              <?php if ($row->type=="Discount"): ?>
                <div class="card voucher-discount">
              <?php endif; ?>
              <?php if ($row->type=="Gift"): ?>
                <div class="card voucher-gift">
              <?php endif; ?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <div class="voucher-title">
                        <?php if ($row->type=="Discount"): ?>
                          <?=format_money($row->discount)?> off
                        <?php endif; ?>
                        <?php if ($row->type=="Gift"): ?>
                          <?=$row->name?>
                        <?php endif; ?>
                      </div>
                      <div class="voucher-min-spend">
                        <?php if ($row->minimumSpend>0): ?>
                          Min. Spend: <?=format_money($row->minimumSpend)?>
                          <?php else: ?>
                            No Minimum Spend
                        <?php endif; ?>
                      </div>
                      <div class="voucher-expiring">
                        <?=days_hours_left($row->validUntil)?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <a href="#" class="btn btn-warning mt-2">Edit</a>
              <?php if ($row->status=="Inactive"): ?>
                  <a href="process.php?action=change-voucher-status&Id=<?=$row->Id?>&status=Active" class="btn btn-primary mt-2">Activate</a>
              <?php endif; ?>
              <?php if ($row->status=="Active"): ?>
                  <a href="process.php?action=change-voucher-status&Id=<?=$row->Id?>&status=Inactive" class="btn btn-danger mt-2">Deactivate</a>
              <?php endif; ?>
            </div>


        <?php endforeach; ?>



              </div>
            </section><!-- End Menu Section -->


<?php include "templates/footer.php"; ?>



<script type="text/javascript">


$(function () {


    $('#input-discount').hide();

    $('#voucherType').change(function(){
        if ($(this).val()=="Discount") {
          $('#voucher-label').html("Discount in peso:");
          $('#input-discount').show();
          $('#input-name').attr("type", "hidden");
          $('#discount-display').show();
        }
        if ($(this).val()=="Gift") {
          $('#voucher-label').html("Gift name:");
          $('#input-discount').attr("type", "hidden");
          $('#input-name').attr("type", "text");
          $('#discount-display').hide();
        }
    });

    $('#input-discount').on("keyup", function() {
      var text = "Php " + $(this).val() + " Off";
      $('#input-name').val(text);
      $('#discount-display').html(text);
    });

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
        getModal.find("#input-price").val($_name.attr("data-price"));
        getModal.find("#input-description").val($_name.attr("data-description"));
        getModal.find("#input-image").attr("required", false);

        $("#formItemModal").modal("show");
      });
    }

    editContact();

  });


function open_modal(itemId){
  var availabilty = document.getElementById("availabilty"+itemId);
  var markAs = document.getElementById("markAs"+itemId);
  if (availabilty.innerHTML=="Available") {
    markAs.innerHTML = "Not Available";
    markAs.style.color = "red";
  }
  else{
    markAs.innerHTML = "Available";
    markAs.style.color = "green";
  }
}

function change_item_status(itemId){
  var availabilty = document.getElementById("availabilty"+itemId);
  var markAs = document.getElementById("markAs"+itemId);
  if (markAs.innerHTML=="Available") {
    availabilty.innerHTML = "Available";
    availabilty.style.color = "green";
  }
  else{
    availabilty.innerHTML = "Not Available";
    availabilty.style.color = "red";
  }

  $.ajax({
      type: "GET",
      url: "process.php?action=change-item-status&Id=" + itemId + "&status=" + availabilty.innerHTML,
    });
}

function best_seller_option(itemId){
  var bestSellerMark = document.getElementById("bestSellerMark"+itemId);
  var isBestSeller = 0;
  if (bestSellerMark.innerHTML=="Best Seller") {
    bestSellerMark.innerHTML = "";
    isBestSeller = 0;
  }
  else{
    bestSellerMark.innerHTML = "Best Seller";
    isBestSeller = 1;
  }

  $.ajax({
      type: "GET",
      url: "process.php?action=best-seller-option&Id=" + itemId + "&value=" + isBestSeller,
    });
}

</script>
