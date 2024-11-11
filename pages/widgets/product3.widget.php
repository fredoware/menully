<?php 
 $cat = category()->get("Id=$item->categoryId");
 $checkVariation = variation()->count("itemId=$item->Id");
 if ($checkVariation) {
   $varFirst = variation()->get("itemId=$item->Id order by price asc limit 1");
   $varLast = variation()->get("itemId=$item->Id order by price desc limit 1");
 }
?>
<div class="d-flex align-items-center justify-content-start clickable" onclick="location.href='item-detail.php?Id=<?=$item->Id?>'">
      <div class="rounded me-4" style="width: 100px; height: 100px;">
            <img src="<?=media_link($item->image);?>" class="img-fluid rounded" alt="">
      </div>
      <div>
            <h6 class="mb-2 text-secondary"><?=$item->name?></h6>
            <?=get_ratings(get_average_ratings($item->Id))?>
            <div class="d-flex mb-2">
     

            <?php if ($checkVariation): ?>
                  <h5 class="fw-bold me-2">$<?=format_money($varFirst->price);?></h5>
            <?php else: ?>
                  <h5 class="fw-bold me-2 text-danger">Coming Soon...</h5>
            <?php endif; ?>
            </div>
      </div>
</div>
