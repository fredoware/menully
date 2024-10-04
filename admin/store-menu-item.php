<?php
  include "templates/header.php";

  $storeId = $_GET['storeId'];

  $Id = $_GET["Id"];

  $category = menuCategory()->get("Id=$Id");

  $categoryList = menuCategory()->list("storeId=$storeId and isDeleted=0");

  $item_list = menuItem()->list("menuCategoryId=$Id and isDeleted=0");

?>


<div class="card bg-light-info shadow-none position-relative overflow-hidden">
<div class="card-body px-4 py-3">
    <div class="row align-items-center">
      
    <div class="col-2 mih-left" >

            <button class="btn btn-warning" onclick="history.back()"><i class="bi bi-arrow-left"></i></button>
          </div>
    <div class="col-9">
        <h4 class="fw-semibold mb-8"><?=$category->name;?>'s Items</h4>
    </div>
    </div>
</div>
</div>

<a class="btn btn-primary" href="store-menu-item-form.php?storeId=<?=$storeId?>">Add New Item +</a>

  <section>
    <div class="container" data-aos="fade-up">

      <div class="modal fade" id="formItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Item Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="process.php?action=item-save" method="post" enctype="multipart/form-data">
              <input type="hidden" name="Id" id="input-Id">
              <input type="hidden" name="storeId" value="<?=$storeId?>">
              Category:
              <select name="menuCategoryId" id="input-menuCategoryId" class="form-select">
                <?php foreach ($categoryList as $row): ?> 
                  <option value="<?=$row->Id?>"><?=$row->name;?></option>
                 <?php endforeach; ?>
              </select>
              Name:
              <input type="text" name="name" id="input-name" class="form-control" required>
              Description:
              <input type="text" name="description" id="input-description" class="form-control" required>
              Price:
              <input type="text" name="price" id="input-price" class="form-control" required>
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

       <?php foreach ($item_list as $item):
       $var = variation()->get("itemId=$item->Id order by price limit 1");
       if ($item->isAvailable) {
        $availabiltyColor = "green";
        $availableMark = "Available";
      }
      else{
        $availabiltyColor = "red";
        $availableMark = "Not Available";
      }
         if ($item->isBestSeller) {
           $bestSellerMark = "Best Seller";
         }
         else{
           $bestSellerMark = "";
         }


          ?>
          <div class="col-lg-4 mb-2 menu-item mt-3" style="min-height:100px !important">
            <div class="card item-items">
              <div class="card-body item-data"
                  data-id="<?=$item->Id;?>"
                  data-name="<?=$item->name;?>"
                  data-price="<?=$item->price;?>"
                  data-menuCategoryId="<?=$item->menuCategoryId;?>"
                  data-image="<?=$item->image;?>"
                  data-description="<?=$item->description;?>"
              >
                <div class="row">
                  <?php if ($item->image): ?>
                  <div class="col text-center">
                    <div class="square-container">
                      <img src="<?=general_link("media/".$item->image)?>" class="crop-box">
                    </div>
                  </div>
                <?php endif; ?>
                  <div class="col">
                    <div class="item-name"><?=$item->name;?></div>
                    <p class="item-description">
                    <?=htmlspecialchars_decode($item->description)?>
                    </p>
                    <p class="item-price">
                      <?=format_money($var->price);?>
                    </p>


                      <span id="availabilty<?=$item->Id?>" style="font-weight:bold;color:<?=$availabiltyColor;?>"><?=$availableMark?></span>
                      <br>
                      <span id="bestSellerMark<?=$item->Id?>" style="font-weight:bold;color:orange;"><?=$bestSellerMark?></span>

                  </div>
                </div>
              </div>
              <div class="card-footer">
              <a href="store-menu-item-form.php?Id=<?=$item->Id?>&storeId=<?=$storeId?>" class="btn btn-warning">Edit</a>
                  <button type="button" class="btn btn-primary" onclick="open_modal('<?=$item->Id?>')"  data-bs-toggle="modal" data-bs-target="#itemModal<?=$item->Id?>">Markings</button>
                  <button class="btn btn-danger" onclick="deleteNotification('process.php?action=item-delete&Id=<?=$item->Id?>&categoryId=<?=$category->Id?>&storeId=<?=$storeId?>')">Delete</button>
              </div>
            </div>
          </div>

          <div class="modal fade" id="itemModal<?=$item->Id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5"><?=$item->name;?></h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="card"  data-bs-dismiss="modal" aria-label="Close" onclick="change_item_status('<?=$item->Id?>')">
                        <div class="card-body text-center">
                          Mark as <br> <b id="markAs<?=$item->Id?>">Status</b>
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="card"  data-bs-dismiss="modal" aria-label="Close" onclick="best_seller_option('<?=$item->Id?>')">
                        <div class="card-body text-center">
                          <span >Add to or Remove from</span> <br> <b style="color:orange;">best Sellers</b>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

       <?php endforeach; ?>



              </div>
            </section><!-- End Menu Section -->


<?php include "templates/footer.php"; ?>



<script type="text/javascript">

$(function () {

    $("#btn-add-category").on("click", function (event) {

      $("#formItemModal #btn-add").show();
      $("#formItemModal #btn-edit").hide();
      $(".form-control").val('');
      $("#input-menuCategoryId").val('<?=$category->Id?>');
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
        getModal.find("#input-menuCategoryId").val($_name.attr("data-menuCategoryId"));
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
    isAvailable = 1;
  }
  else{
    availabilty.innerHTML = "Not Available";
    availabilty.style.color = "red";
    isAvailable = 0;
  }

  $.ajax({
      type: "GET",
      url: "process.php?action=change-item-status&Id=" + itemId + "&isAvailable=" + isAvailable,
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
