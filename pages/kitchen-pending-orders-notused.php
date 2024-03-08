<?php
  include "templates/header-store.php";

  $status = "Pending";

  $order_list = orderMain()->list("status='$status' and storeCode='$storeName'");

  function get_total_amount($orderNumber){
    $result = 0;

    foreach (orderItem()->list("orderNumber='$orderNumber'") as $row) {
      $item = menuItem()->get("Id=$row->itemId");
      $result += $item->price*$row->quantity;
    }


    return format_money($result);
  }

?>

<main id="main">

  <section id="menu" class="menu">
    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2>My Orders</h2>
      </div>

      <div class="row">


<?php foreach ($order_list as $item):
  $totalAmount = get_total_amount($item->orderNumber);
   ?>

   <div class="col-lg-4 menu-item mb-3" id="itemCard<?=$item->Id?>">
     <div class="alert alert-danger" role="alert"  data-bs-toggle="modal" data-bs-target="#orderModal<?=$item->Id?>">
       <div class="row text-center">
         <div class="col">
           Customer: <?=$item->customer?> <br><?=$item->orderNumber?>
         </div>
         <div class="col">
           Total: <p><?=$totalAmount?></p>
         </div>
         <div class="col">
           Status: <p><?=$item->status?></p>
         </div>
       </div>
      </div>
   </div>

   <div class="modal fade" id="orderModal<?=$item->Id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h1 class="modal-title fs-5">Order #: <?=$item->orderNumber?></h1>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
           <div class="modal-body">

             <?php foreach (orderItem()->list("orderNumber='$item->orderNumber'") as $orderItem):
                 $menuItem = menuItem()->get("Id=$orderItem->itemId");
                 $itemTotal = $menuItem->price*$orderItem->quantity;
                ?>

             <div class="row">
               <div class="col">
                 <?=$menuItem->name?> x <?=$orderItem->quantity?>
               </div>
               <div class="col-4 text-end">
                 <?=format_money($itemTotal)?>
               </div>
             </div>


              <?php endforeach; ?>

             <hr>
             <div class="row">
               <div class="col">
                 Total
               </div>
               <div class="col-4 text-end">
                 <?=$totalAmount?>
               </div>
             </div>
           </div>
           <div class="modal-footer">

               <button class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" onclick="change_order_status('<?=$item->Id?>','Confirmed')">Confirm</button>
               <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"  onclick="change_order_status('<?=$item->Id?>','Canceled')">Cancel Order</button>

           </div>
       </div>
     </div>
   </div>

<?php endforeach; ?>

      </div>

    </div>
  </section><!-- End Menu Section -->


<script type="text/javascript">

var currentPending = 0;

var intervalId = window.setInterval(function(){
  $.ajax({
      type: "GET",
      url: "api-pending-orders.php?storeName=<?=$storeName?>",
      success: function(data){
        const obj = JSON.parse(data);
        if (currentPending!=obj.totalPending) {
          alert(obj.totalPending + " new pending orders");
          currentPending = obj.totalPending;
        }
      }
    });
}, 5000);


function change_order_status(itemId, status){
  var itemCard = document.getElementById("itemCard"+itemId);
  itemCard.style.display = "none";

  $.ajax({
      type: "GET",
      url: "process.php?action=change-order-status&Id=" + itemId + "&status=" + status,
    });
}

</script>


<?php include "templates/footer.php"; ?>
