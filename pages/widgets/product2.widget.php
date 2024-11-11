<?php 
 $cat = category()->get("Id=$item->categoryId");
 $checkVariation = variation()->count("itemId=$item->Id");
 if ($checkVariation) {
   $varFirst = variation()->get("itemId=$item->Id order by price asc limit 1");
   $varLast = variation()->get("itemId=$item->Id order by price desc limit 1");
 }
?>

<div class="border border-primary rounded position-relative vesitable-item clickable" onclick="location.href='item-detail.php?Id=<?=$item->Id?>'">
<div class="vesitable-img">
      <img src="<?=media_link($item->image);?>" class="img-fluid w-100 rounded-top product-image" alt="">
</div>
<div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?=$cat->name?></div>
<div class="p-4 rounded-bottom">
      <h4><?=$item->name?></h4>
      <p><?=char_limit(strip_tags(html_entity_decode($item->description)),30)?></p>
      <div class="d-flex justify-content-between flex-lg-wrap">
      <?php if ($checkVariation): ?>
            <?php if ($checkVariation==1): ?>
            <p class="text-dark fs-5 fw-bold mb-0">$<?=format_money($varFirst->price);?></p>
            <?php else: ?>
                  <p class="text-dark fs-5 fw-bold mb-0">Starts at $<?=format_money($varFirst->price);?></p>
                  <small class="text-success">Multiple sizes available</small>
            <?php endif; ?>
      <?php else: ?>
      <p class="fs-5 fw-bold mb-0 text-danger">Coming Soon...</p>
      <?php endif; ?>
      </div>
</div>
</div>
