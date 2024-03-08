<?php
  include "templates/header.php";

  $my_orders = $_SESSION["myOrders"];

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



<?php foreach ($my_orders as $row):
  $item = orderMain()->get("orderNumber='$row'");
  $totalAmount = get_total_amount($item->orderNumber);
   ?>

   <div class="col-lg-4 menu-item mb-3">
     <div class="card" data-bs-toggle="modal" data-bs-target="#orderModal<?=$row?>">
       <div class="card-body">
         <div class="row text-center">
           <div class="col">
             Order # <p><?=$item->orderNumber?></p>
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
   </div>

   <div class="modal fade" id="orderModal<?=$row?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
       </div>
     </div>
   </div>

<?php endforeach; ?>



      </div>



    </div>
  </section><!-- End Menu Section -->


<?php include "templates/footer.php"; ?>
