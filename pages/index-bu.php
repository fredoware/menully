<?php
  $ROOT_DIR="../";
  include $ROOT_DIR . "templates/header.php";

  $category_list = menu_category()->list("storeId=$store->Id");

  $cart = $_SESSION["cart"];

?>


  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
      <div class="row justify-content-between gy-5">
        <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2 data-aos="fade-up"><?=$store->name?><br>Menu Book</h2>
          <p data-aos="fade-up" data-aos-delay="100">
            Check out delicious menu
          </p>
        </div>
        <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
          <img src="../media/<?=$store->logo?>" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->


<main id="main">

  <section id="menu" class="menu">
    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2><?=$store->name;?> Menu</h2>
      </div>

      <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">

        <?php
          $count = 0;
         foreach ($category_list as $row):
           $count += 1;
           if ($count==1) {
             $activeStatus = "active show";
           }
           else{
             $activeStatus = "";
           }
           ?>
          <li class="nav-item">
            <a class="nav-link <?=$activeStatus?>" data-bs-toggle="tab" data-bs-target="#menu-link<?=$row->Id?>">
              <h4><?=$row->name;?></h4>
            </a>
          </li><!-- End tab nav item -->
        <?php endforeach; ?>
          </ul>

                <div class="tab-content" data-aos="fade-up" data-aos-delay="300">

                  <?php
                    $count = 0;
                   foreach ($category_list as $row):
                     $item_list = menu_item()->list("menuCategoryId=$row->Id");
                     $count += 1;
                     if ($count==1) {
                       $activeStatus = "active show";
                     }
                     else{
                       $activeStatus = "";
                     }
                     ?>


                         <div class="tab-pane fade <?=$activeStatus?>" id="menu-link<?=$row->Id?>">

                           <div class="tab-header text-center">
                             <h3><?=$row->name;?></h3>
                           </div>

                           <div class="row gy-5">

                            <?php foreach ($item_list as $item):

                               ?>
                               <div class="col-lg-4 menu-item" style="margin-bottom:-30px" data-bs-toggle="modal" data-bs-target="#itemModal<?=$item->Id?>">

                                 <div class="card">
                                   <div class="card-body">
                                     <div class="row">
                                       <div class="col">
                                        <img src="../media/<?=$item->image;?>" width="100%" alt="">
                                       </div>
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
                                    <img src="../media/<?=$item->image;?>" width="100%" alt="">
                                     <div class="modal-header">
                                       <h1 class="modal-title fs-5"><?=$item->name;?></h1>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                       <h4><?=$item->name;?></h4>
                                       <p class="ingredients">
                                         <?=$item->description;?>
                                       </p>
                                       <p class="price">
                                         <?=format_money($item->price);?>
                                       </p>
                                     </div>
                                     <div class="modal-footer">
                                       <form action="process.php?action=add-to-cart" method="post">
                                         <input type="hidden" name="quantity" value="1" id="itemQuantity<?=$item->Id?>"> <br>
                                         <input type="hidden" name="quantity" value="<?=$item->price?>" id="itemPrice<?=$item->Id?>"> <br>
                                         <input type="hidden" name="itemId" value="<?=$item->Id?>"> <br>
                                         <button type="button" class="btn btn-warning" onclick="update_quantity('<?=$item->Id?>', -1)">-</button>
                                         <button type="button" class="btn btn-warning" id="quantity<?=$item->Id?>">1</button>
                                         <button type="button" class="btn btn-warning" onclick="update_quantity('<?=$item->Id?>', 1)">+</button>
                                         <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" onclick="add_to_cart('<?=$item->Id?>')">Add to cart</button>
                                       </form>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                            <?php endforeach; ?>


                           </div>
                         </div><!-- End Starter Menu Content -->


                  <?php endforeach; ?>


                </div>

              </div>
            </section><!-- End Menu Section -->

</main>

<style media="screen">
  .bottom-sheet-dialog{
    position: fixed;
    bottom: 10px;
    text-align: center;
    width: 100%;
  }
</style>


<div class="content-fluid bottom-sheet-dialog">
  <div class="card bg-primary">
    <div class="card-body">
      <div class="row">
        <div class="col" id="cartDisplayTotalItem">
          0
        </div>
        <div class="col">
          View your cart
        </div>
        <div class="col" id="cartDisplayTotalAmount">
          0
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

const cart = {};

var cartTotalItem = 0;
var cartTotalAmount = 0;

function update_quantity(itemId, addedValue){
  var quantity = document.getElementById("itemQuantity"+itemId);
  var displayQuantity = document.getElementById("quantity"+itemId);

  var newQuantity = parseInt(quantity.value) + parseInt(addedValue);
  if (newQuantity>=1) {
    quantity.value = parseInt(quantity.value) + parseInt(addedValue);
    displayQuantity.innerHTML = quantity.value;
  }
}


function add_to_cart(itemId){
  var quantity = document.getElementById("itemQuantity"+itemId);
  var price = document.getElementById("itemPrice"+itemId);
  var totalItem = document.getElementById("cartDisplayTotalItem");
  var totalAmount = document.getElementById("cartDisplayTotalAmount");
  var itemValue = parseInt(quantity.value);
  cartTotalItem += itemValue;
  cartTotalAmount += parseFloat(price.value)*itemValue;
  totalItem.innerHTML = cartTotalItem;
  totalAmount.innerHTML = cartTotalAmount;
  $.ajax({
      type: "GET",
      url: "process.php?action=add-to-cart&itemId=" + itemId + "&value=" + itemValue,
    });
}

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>


<?php include $ROOT_DIR . "templates/footer.php"; ?>
