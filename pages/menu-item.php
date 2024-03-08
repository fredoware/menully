<?php
  include "templates/header.php";

  $Id = $_GET["Id"];

  $category = menuCategory()->get("Id=$Id");

  $available_items = menuItem()->list("menuCategoryId=$Id and status='Available' order by priority");
  $unavailable_items = menuItem()->list("menuCategoryId=$Id and status='Not Available'");

  $cart = $_SESSION["cart"];

  $totalAmount = 0;
  $totalQuantity = 0;

  foreach ($cart as $key => $qty){
    $item = menuItem()->get("Id=$key");
    $totalAmount += $item->price*$qty;
    $totalQuantity += $qty;
  }

?>

  <section>
    <div class="container" data-aos="fade-up">

      <div class="menu-header text-center">
        <h6><?=$category->name;?></h6>
      </div>

      <div class="row gy-5">

       <?php foreach ($available_items as $item):


          ?>
          <div class="col-lg-4 col-6 menu-item" style="margin-bottom:-30px" data-bs-toggle="modal" data-bs-target="#itemModal<?=$item->Id?>">

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
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="itemModal<?=$item->Id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <?php if ($item->image): ?>
                  <div class="square-container">
                    <img src="../media/<?=$item->image;?>">
                  </div>
                <?php endif; ?>
                <div class="modal-header">
                  <h1 class="modal-title fs-5"><?=$item->name;?></h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p class="ingredients">
                    <?=$item->description;?>
                  </p>
                  <p class="price">
                    <?=format_money($item->price);?>
                  </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-warning" onclick="update_quantity('<?=$item->Id?>', -1)">-</button>
                  <button type="button" class="btn btn-warning" id="quantity<?=$item->Id?>">1</button>
                  <button type="button" class="btn btn-warning" onclick="update_quantity('<?=$item->Id?>', 1)">+</button>
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" onclick="add_to_cart('<?=$item->Id?>', '<?=$item->price;?>')">Add to cart</button>
                </div>
              </div>
            </div>
          </div>
       <?php endforeach; ?>


           <?php foreach ($unavailable_items as $item):


              ?>
              <div class="col-lg-4 menu-item" style="margin-bottom:-30px" data-bs-toggle="modal" data-bs-target="#itemModal<?=$item->Id?>">

                <div class="card" style="opacity: 0.4; filter: alpha(opacity=40);">
                  <div class="card-body">
                    <div class="row">
                      <?php if ($item->image): ?>
                      <div class="col">
                          <img src="../media/<?=$item->image;?>" width="100%" alt="">
                      </div>
                    <?php endif; ?>
                      <div class="col">
                        <h4><?=$item->name;?></h4>
                        <p class="ingredients">
                          <?=$item->description;?>
                        </p>
                        <p class="price">
                          <?=format_money($item->price);?>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="itemModal<?=$item->Id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <?php if ($item->image): ?>
                      <img src="../media/<?=$item->image;?>" width="100%" alt="">
                    <?php endif; ?>
                    <div class="modal-header">
                      <h1 class="modal-title fs-5"><?=$item->name;?></h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color:red;">
                      Sorry, this item is not available.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                  </div>
                </div>
              </div>
           <?php endforeach; ?>


              </div>
            </section><!-- End Menu Section -->


<div class="content-fluid bottom-sheet-dialog" onclick="location.href='my-cart.php'" id="bottom-sheet" style="display:none">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-2" id="cartDisplayTotalItem">
          0
        </div>
        <div class="col">
          View your cart
        </div>
        <div class="col-3" id="cartDisplayTotalAmount">
          0
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

const cart = {};

var totalItem = document.getElementById("cartDisplayTotalItem");
var totalAmount = document.getElementById("cartDisplayTotalAmount");
var bottomSheet = document.getElementById("bottom-sheet");
var cartTotalItem = <?=$totalQuantity?>;
var cartTotalAmount = <?=$totalAmount?>;

if (cartTotalItem>0) {
  bottomSheet.style.display = "";
}


totalItem.innerHTML = cartTotalItem;
totalAmount.innerHTML = format_money(cartTotalAmount);


function update_quantity(itemId, addedValue){
  var quantity = document.getElementById("quantity"+itemId);

  var newQuantity = parseInt(quantity.innerHTML) + parseInt(addedValue);

  if (newQuantity>=1) {
    quantity.innerHTML = newQuantity;
  }

}

function add_to_cart(itemId, price){
  var quantity = document.getElementById("quantity"+itemId);
  var itemValue = parseInt(quantity.innerHTML);
  cartTotalItem += itemValue;
  cartTotalAmount += parseFloat(price)*itemValue;
  totalItem.innerHTML = cartTotalItem;
  totalAmount.innerHTML = format_money(cartTotalAmount);
  quantity.innerHTML = 1;
  $.ajax({
      type: "GET",
      url: "process.php?action=add-to-cart&itemId=" + itemId + "&value=" + itemValue,
    });
  bottomSheet.style.display = "";
}




</script>


<?php include "templates/footer.php"; ?>
