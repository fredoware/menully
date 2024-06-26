<?php
  include "templates/header.php";

  if (isset($_SESSION['login_id'])) {
    $userGoogleId = $_SESSION['login_id'];
    $user = user()->get("google_id='$userGoogleId'");
  }

  $cart = $_SESSION["cart"];

  $totalAmount = 0;

  foreach ($cart as $key => $qty){
    $item = menuItem()->get("Id=$key");
    $totalAmount += $item->price*$qty;
  }

?>

<main id="main">

  <section id="menu" class="menu">
    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2>My Cart</h2>
      </div>

      <div class="row">

        <?php
         foreach ($cart as $key => $qty):
          $item = menuItem()->get("Id=$key");
          $total = $item->price*$qty;

           ?>
      <div class="col-lg-4 menu-item mb-3" id="cartItem<?=$item->Id;?>">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <?php if ($item->image): ?>
              <div class="col">
                  <img src="../media/<?=$item->image;?>" width="100%" alt="">
              </div>
            <?php endif; ?>
              <div class="col">
                <b><?=$item->name;?></b>
                <p class="ingredients">
                  <?=$item->description;?>
                </p>
                <p class="price">
                  <?=format_money($item->price);?>
                </p>

                <button type="button" class="btn btn-warning" onclick="update_quantity('<?=$item->Id?>', '<?=$item->price?>', -1)">-</button>
                <button type="button" class="btn btn-warning" id="quantity<?=$item->Id?>"><?=$qty?></button>
                <button type="button" class="btn btn-warning" onclick="update_quantity('<?=$item->Id?>', '<?=$item->price?>', 1)">+</button>


                <div id="totalPrice<?=$item->Id?>" class="mt-3" style="font-size:20px;font-weight:bold;color:red">
                  <?=format_money($total);?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php endforeach; ?>



      </div>



    </div>
  </section><!-- End Menu Section -->

</main>

<br><br><br><br>


  <div class="content-fluid dialog-place-order">
    <div class="row">
      <div class="col-6">
        Voucher:
      </div>
      <div class="col-6" onclick="location.href='vouchers'">
        <?php if ($_SESSION["voucherId"]):
          $voucherId = $_SESSION["voucherId"];
          $voucher = voucher()->get("Id=$voucherId");
           ?>
           <div class="cart-selected-voucher">
             <span><?=$voucher->name?></span>
           </div>
          <?php else: ?>
            <span>Select Voucher <i class="bi bi-chevron-right"></i></span>
        <?php endif; ?>
      </div>
      <div class="col-6">
        <div class="mt-3">
            Total: <span id="cartDisplayTotalAmount">0</span>
        </div>
      </div>
      <div class="col-6">
        <?php if (isset($_SESSION['login_id'])): ?>
          <div class="btn-place-order"  data-bs-toggle="modal" data-bs-target="#orderModal">
          <?php else: ?>
             <div class="btn-place-order"  onclick="location.href='../google-log-in/login.php'">
        <?php endif; ?>
          Place Order
        </div>
      </div>
    </div>

</div>

<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Order Detail</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../pages/process.php?action=place-order" method="post">
        <input type="hidden" name="storeCode"  class="form-control" value="<?=$storeCode?>" required>
        <div class="modal-body">
          <b>Customer</b>
          <input type="hidden" name="customerId" value="<?=$user->Id?>">
          <input type="text" name="customer"  class="form-control" value="<?=$user->name?>" disabled>
          <b>Notes to kitchen</b>
          <textarea name="notes" class="form-control"></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script type="text/javascript">


var totalAmount = document.getElementById("cartDisplayTotalAmount");
var cartTotalAmount = <?=$totalAmount?>;

totalAmount.innerHTML = format_money(cartTotalAmount);

function update_quantity(itemId, price, addedValue){
  var quantity = document.getElementById("quantity"+itemId);
  var totalPrice = document.getElementById("totalPrice"+itemId);
  var cartItem = document.getElementById("cartItem"+itemId);

  var newQuantity = parseInt(quantity.innerHTML) + parseInt(addedValue);

  var newTotal = 0;
  if (addedValue==1) {
    newTotal = parseFloat(cartTotalAmount) + parseFloat(price);
  }
  else{
    newTotal = parseFloat(cartTotalAmount) - parseFloat(price);
  }
  totalAmount.innerHTML = format_money(newTotal);
  cartTotalAmount = newTotal;


  if (newQuantity>=1) {
    quantity.innerHTML = newQuantity;
    totalPrice.innerHTML = format_money(newQuantity*parseFloat(price));
    $.ajax({
        type: "GET",
        url: "../pages/process.php?action=update-cart&itemId=" + itemId + "&value=" + newQuantity,
      });
  }
  else{
    cartItem.style.display = "none";
    $.ajax({
        type: "GET",
        url: "../pages/process.php?action=remove-from-cart&itemId=" + itemId,
      });
  }
}



</script>

<?php include "templates/footer.php"; ?>
