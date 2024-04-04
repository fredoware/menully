<?php
  include "templates/header.php";

  $myOrderList = orderMain()->list("customerId=$user->Id");

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
        <h2>My Orders</h2>
      </div>

      <div class="row">



<?php foreach ($myOrderList as $item):
  $totalAmount = get_total_amount($item->orderNumber);
   ?>

   <div class="col-lg-4 menu-item mb-3">
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
               <div class="cart-selected-voucher">
                 <span><?=$voucher->name?></span>
               </div>
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
       </div>
     </div>
   </div>

<?php endforeach; ?>



      </div>



    </div>
  </section><!-- End Menu Section -->


<?php include "templates/footer.php"; ?>
