<?php 
$cat = category()->get("Id=$item->categoryId");
$checkVariation = variation()->count("itemId=$item->Id");
if ($checkVariation) {
  $varFirst = variation()->get("itemId=$item->Id order by price asc limit 1");
  $varLast = variation()->get("itemId=$item->Id order by price desc limit 1");
}
?>

<div class="col-md-6 col-lg-6 col-xl-3" data-aos="fade-up"  data-aos-duration="1000">
      <div class="rounded position-relative fruite-item clickable" onclick="location.href='csa-item-detail.php?Id=<?=$item->Id?>'">
            <?php if ($item->isFeatured): ?>
            <img src="templates/img/featured_products.png" class="featured-product position-absolute">
            <?php endif; ?>

            <?php if ($item->isAvailable): ?>
                  <div class="fruite-img">
                  <img src="<?=media_link($item->image);?>" class="img-fluid w-100 rounded-top product-image" alt="">
                  </div>
                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?=$cat->name?></div>
            <?php else: ?>
                  <div class="fruite-img">
                  <img src="<?=media_link($item->image);?>" class="img-fluid w-100 rounded-top product-image image-not-available" alt="">
                  </div>
                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?=$cat->name?></div>
                  <div class="product-not-available">Not Available</div>
            <?php endif; ?>

            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                  <h4><?=$item->name?></h4>
                  <p><?=char_limit(strip_tags(html_entity_decode($item->description)),50)?></p>
                  <div class="d-flex justify-content-between flex-lg-wrap">
 
                  </div>
            </div>
      </div>
</div>