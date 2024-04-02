<?php
  include "templates/header-store.php";

  $date = get_query_string("date", date("Y-m-d"));

  $status = $_GET["status"];

  $order_list = orderMain()->list("status='$status' and storeCode='$storeName' and date='$date'");

  $totalItems = count($order_list);

  function get_total_amount($orderNumber){
    $result = 0;

    foreach (orderItem()->list("orderNumber='$orderNumber'") as $row) {
      $item = menuItem()->get("Id=$row->itemId");
      $result += $item->price*$row->quantity;
    }


    return $result;
  }

?>

<main id="main">

  <section id="menu" class="menu">
    <div class="container" data-aos="fade-up">


      <div class="section-header">
        <h2><?=$status?> Orders
        <span class="badge text-bg-warning"><?=$totalItems?></span>
      </h2>


                    <form  action="kitchen-orders.php" method="get"  class="input-group mt-3 mb-3">

                        <input type="hidden" name="status" value="<?=$status?>">
                        <input type="date" class="form-control" value="<?=$date?>" name="date"  onchange="this.form.submit()"  required/>

                    </form>

      </div>

      <div class="row">



<?php foreach ($order_list as $item):
  $totalAmount = get_total_amount($item->orderNumber);
  $customer = user()->get("Id=$item->customerId");
   ?>

   <div class="col-lg-4 menu-item mb-3" id="itemCard<?=$item->Id?>">
     <div class="card" data-bs-toggle="modal" data-bs-target="#orderModal<?=$item->Id?>">
       <div class="card-body">
         <div class="row">
           <div class="col order-label">
             Date Ordered:
           </div>
           <div class="col order-value">
             <?=$item->date?>
           </div>
         </div>

         <div class="row">
           <div class="col order-label">
             Order Number:
           </div>
           <div class="col order-value">
             <?=$item->orderNumber?>
           </div>
         </div>

         <div class="row">
           <div class="col order-label">
             Customer:
           </div>
           <div class="col order-value">
             <?=$customer->name?>
           </div>
         </div>

         <?php if ($item->voucherId):
           $voucher = voucher()->get("Id=$item->voucherId");
           $finalAmount = $totalAmount-$voucher->discount;
           ?>

           <div class="row">
             <div class="col order-label">
               Sub-Total:
             </div>
             <div class="col order-value">
               <?=format_money($totalAmount)?>
             </div>
           </div>

           <div class="row mt-3 mb-3">
             <div class="col order-label">
               Voucher:
             </div>
             <div class="col order-value">
               <span class="cart-selected-voucher"><?=$voucher->name?></span>
             </div>
           </div>

           <div class="row">
             <div class="col order-label">
               Total:
             </div>
             <div class="col order-value">
               <?=format_money($finalAmount)?>
             </div>
           </div>

           <?php else: ?>

           <div class="row">
             <div class="col order-label">
               Total:
             </div>
             <div class="col order-value">
               <?=format_money($totalAmount)?>
             </div>
           </div>

         <?php endif; ?>



         <div class="row">
           <div class="col order-label">
             Status:
           </div>
           <div class="col order-value">
             <?=$item->status?>
           </div>
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

             <b>Notes:</b> <?=$item->notes;?>

             <hr>

             <?php if ($item->voucherId):
               $voucher = voucher()->get("Id=$item->voucherId");
               $finalAmount = $totalAmount-$voucher->discount;
               ?>

               <div class="row">
                 <div class="col order-label">
                   Sub-Total:
                 </div>
                 <div class="col order-value">
                   <?=format_money($totalAmount)?>
                 </div>
               </div>

               <div class="row mt-3 mb-3">
                 <div class="col-3 order-label">
                   Voucher:
                 </div>
                 <div class="col order-value">
                   <span class="cart-selected-voucher"><?=$voucher->name?></span>
                 </div>
               </div>

               <div class="row">
                 <div class="col order-label">
                   Total:
                 </div>
                 <div class="col order-value">
                   <?=format_money($finalAmount)?>
                 </div>
               </div>

               <?php else: ?>

               <div class="row">
                 <div class="col order-label">
                   Total:
                 </div>
                 <div class="col order-value">
                   <?=format_money($totalAmount)?>
                 </div>
               </div>

             <?php endif; ?>
           </div>
           <div class="modal-footer">

             <?php if ($item->status=="Pending"): ?>
               <button class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" onclick="change_order_status('<?=$item->Id?>','Confirmed')">Confirm</button>
               <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"  onclick="change_order_status('<?=$item->Id?>','Canceled')">Cancel Order</button>
             <?php endif; ?>

            <?php if ($item->status=="Confirmed"): ?>
               <button class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" onclick="change_order_status('<?=$item->Id?>','Delivered')">Delivered</button>
               <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"  onclick="change_order_status('<?=$item->Id?>','Canceled')">Cancel Order</button>
             <?php endif; ?>

           </div>
       </div>
     </div>
   </div>

<?php endforeach; ?>

      </div>

    </div>
  </section><!-- End Menu Section -->

<script type="text/javascript">

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
