<?php
  include "templates/header-store.php";

  $item_list = menuItem()->list("storeId=$store->Id and isBestSeller=1");

?>

  <section id="menu" class="menu">
    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2>Best Sellers</h2>
      </div>

                           <div class="row gy-5">

                            <?php foreach ($item_list as $item):

                               ?>
                               <div id="item<?=$item->Id?>" class="col-lg-4 menu-item" style="margin-bottom:-30px" data-bs-toggle="modal" data-bs-target="#itemModal<?=$item->Id?>">

                                 <div class="card">
                                   <div class="card-body">
                                     <div class="row">
                                       <?php if ($item->image): ?>
                                       <div class="col">
                                         <div class="square-container">
                                           <img src="../media/<?=$item->image;?>">
                                         </div>
                                       </div>
                                     <?php endif; ?>
                                       <div class="col">
                                         <div class="item-name"><?=$item->name;?></div>
                                         <p class="item-description">
                                           <?=$item->description;?>
                                         </p>
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
                                     <div class="modal-header">
                                       <h1 class="modal-title fs-5"><?=$item->name;?></h1>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                       <div class="row">

                                         <div class="col">
                                           <div class="card"  data-bs-dismiss="modal" aria-label="Close" onclick="best_seller_option('<?=$item->Id?>')">
                                             <div class="card-body text-center">
                                               <span >Remove from</span> <br> <b style="color:orange;">best Sellers</b>
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

              </div>
            </section><!-- End Menu Section -->



<script type="text/javascript">


function best_seller_option(itemId){
  var item = document.getElementById("item"+itemId);
  item.style.display = "none";

  $.ajax({
      type: "GET",
      url: "process.php?action=best-seller-option&Id=" + itemId + "&value=" + 0,
    });
}

</script>



<?php include "templates/footer.php"; ?>
