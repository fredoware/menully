<?php
  include "templates/header-store.php";

  $Id = $_GET["Id"];

  $category = menuCategory()->get("Id=$Id");

  $item_list = menuItem()->list("menuCategoryId=$Id");

?>

  <section>
    <div class="container" data-aos="fade-up">

      <div class="menu-header text-center">
        <h6><?=$category->name;?></h6>
      </div>


      <a type="button" class="btn btn-warning" href="javascript:void(0)" id="btn-add-category">Add Item</a>

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
              <input type="hidden" name="menuCategoryId" value="<?=$category->Id?>">
              <input type="hidden" name="storeId" value="<?=$store->Id?>">
              Name:
              <input type="text" name="name" id="input-name" class="form-control" required>
              Description:
              <input type="text" name="description" id="input-description" class="form-control" required>
              Price:
              <input type="text" name="price" id="input-price" class="form-control" required>

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



      <div class="row mt-3">

       <?php foreach ($item_list as $item):
         if ($item->status=="Available") {
           $availabiltyColor = "green";
         }
         else{
           $availabiltyColor = "red";
         }
         if ($item->isBestSeller) {
           $bestSellerMark = "Best Seller";
         }
         else{
           $bestSellerMark = "";
         }


          ?>
          <div class="col-lg-4 col-6 menu-item mt-3" onclick="open_modal('<?=$item->Id?>')" style="margin-bottom:-30px" data-bs-toggle="modal" data-bs-target="#itemModal<?=$item->Id?>">

            <div class="card">
              <div class="card-header">
                  <?php if ($item->image): ?>
                    <div class="square-container">
                      <img src="../media/<?=$item->image;?>">
                    </div>
                  <?php endif; ?>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col text-center">
                    <div class="item-name"><?=$item->name;?></div>
                    <p class="item-price">
                      <?=format_money($item->price);?>
                    </p>

                    <span id="availabilty<?=$item->Id?>" style="font-weight:bold;color:<?=$availabiltyColor;?>"><?=$item->status?></span>
                    <br>
                    <span id="bestSellerMark<?=$item->Id?>" style="font-weight:bold;color:orange;"><?=$bestSellerMark?></span>
                  </div>
                </div>
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
