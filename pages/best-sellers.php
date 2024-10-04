<?php
  include "templates/header.php";

  $available_items = menuItem()->list("storeId=$store->Id and isDeleted=0 and isBestSeller=1 and status='Available' order by priority");

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
    <div class="container">

        <div class="menu-item-header">
            <div class="row">
                <div class="col-2 mih-left" onclick="window.history.go(-1)">
                    <i class="bi bi-arrow-left"></i>
                </div>
                <div class="col mih-center">
                    <h6>Best Sellers</h6>
                </div>
                <div class="col-2 mih-right" data-bs-toggle="modal" data-bs-target="#menuCategory">
                    <i class="bi bi-menu-app"></i>
                </div>
            </div>
        </div>


        <div class="row gy-5" data-aos="fade-up">

            <?php foreach ($available_items as $item):
          $varationList = variation()->list("itemId=$item->Id order by price");
          $price = 0;
          $varId = 0;
          if (count($varationList)>0) {
            $price = $varationList[0]->price;
            $varId = $varationList[0]->Id;
          }
          if ($item->isAvailable) {
            $checkAvailability = "";
          }
          else{
            $checkAvailability = "opacity: 0.4; filter: alpha(opacity=40);";
          }

          ?>
            <div class="col-lg-4 col-6 menu-item" style="margin-bottom:-30px" data-bs-toggle="modal"
                data-bs-target="#itemModal<?=$item->Id?>">

                <div class="card" style="<?=$checkAvailability?>">
                    <div class="card-header">
                        <div class="square-container">
                            <?php if ($item->image): ?>
                                <img src="../media/<?=$item->image;?>">
                            <?php else: ?>
                                <img src="../media/<?=$store->logo?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center">
                                <div class="item-name"><?=$item->name;?></div>
                                <p class="item-price">
                                <?=format_money($price);?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div style="border:0px" class="modal fade" id="itemModal<?=$item->Id?>" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="square-container">
                                    <?php if ($item->image): ?>
                                        <img src="../media/<?=$item->image;?>">
                                    <?php else: ?>
                                        <img src="../media/<?=$store->logo?>">
                                    <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <h1 class="modal-title fs-5"><?=$item->name;?></h1>

                                    <p class="ingredients">
                                    <?=htmlspecialchars_decode($item->description)?>
                                    </p>
                                    <p class="price" id="priceDisplay<?=$item->Id?>">
                                        <?=format_money($price);?>
                                    </p>
                                    <input type="hidden" id="price<?=$item->Id?>" value="<?=$price?>">
                                    <input type="hidden" id="varId<?=$item->Id?>" value="<?=$varId?>">
                                </div>
                            </div>
                            
                            
                            <hr>
                <?php foreach ($varationList as $var): ?> 
                  <button type="button" class="btn btn-outline-warning" onclick="change_variation('<?=$item->Id?>', '<?=$var->price?>', '<?=$var->Id?>')"><?=$var->unit;?></button>
                 <?php endforeach; ?>
                        </div>
                        <?php if ($item->isAvailable): ?>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning"
                                onclick="update_quantity('<?=$item->Id?>', -1)">-</button>
                            <button type="button" class="btn btn-warning" id="quantity<?=$item->Id?>">1</button>
                            <button type="button" class="btn btn-warning"
                                onclick="update_quantity('<?=$item->Id?>', 1)">+</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close"
                                onclick="add_to_cart('<?=$item->Id?>')">Add to cart</button>
                        </div>
                            <?php else: ?>
                                <p class="text-danger">This item is not available</p>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>



        </div>
</section><!-- End Menu Section -->


<div class="content-fluid bottom-sheet-dialog" onclick="location.href='cart'" id="bottom-sheet" style="display:none">
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

if (cartTotalItem > 0) {
    bottomSheet.style.display = "";
}


totalItem.innerHTML = cartTotalItem;
totalAmount.innerHTML = format_money(cartTotalAmount);


function update_quantity(itemId, addedValue) {
    var quantity = document.getElementById("quantity" + itemId);

    var newQuantity = parseInt(quantity.innerHTML) + parseInt(addedValue);

    if (newQuantity >= 1) {
        quantity.innerHTML = newQuantity;
    }

}

function change_variation(itemId, varPrice, varId){
  var price = document.getElementById("price" + itemId);
  var Id = document.getElementById("varId" + itemId);
  var priceDisplay = document.getElementById("priceDisplay" + itemId);
  price.value = varPrice;
  Id.value = varId;
  priceDisplay.innerHTML = format_money(varPrice);
}

function add_to_cart(itemId) {
    var quantity = document.getElementById("quantity" + itemId);
    var price = document.getElementById("price" + itemId);
    var varId = document.getElementById("varId" + itemId);
    var itemValue = parseInt(quantity.innerHTML);
    cartTotalItem += itemValue;
    cartTotalAmount += parseFloat(price.value) * itemValue;
    totalItem.innerHTML = cartTotalItem;
    totalAmount.innerHTML = format_money(cartTotalAmount);
    quantity.innerHTML = 1;
    $.ajax({
        type: "GET",
        url: "../pages/process.php?action=add-to-cart&itemId=" + itemId + "&varId=" + varId.value + "&value=" + itemValue,
    });
    bottomSheet.style.display = "";
}
</script>


<?php include "templates/footer.php"; ?>