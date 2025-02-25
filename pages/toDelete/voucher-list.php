<?php
  include "templates/header.php";

  $voucherList = voucher()->list("status='Active' and storeId=$store->Id");

  $myVoucherList = array();
    $custVoucherList = custVoucher()->list("custId=$customer->Id and status='Pending'");
    foreach ($custVoucherList as $row) {
      $voucher = voucher()->get("Id=$row->voucherId");
      array_push($myVoucherList, $voucher);
    }

    $voucherList = array();
    $allVoucherList = voucher()->list("status='Active' and storeId=$store->Id");
    foreach ($allVoucherList as $row) {
      $voucherExist = custVoucher()->count("custId=$customer->Id and voucherId=$row->Id");
      if (!$voucherExist) {
          array_push($voucherList, $row);
      }
    }

?>

<main id="main">

  <section id="menu" class="menu">
    <div class="container" data-aos="fade-up">


      <div class="row">


<?php if ($myVoucherList): ?>

  <div class="section-header">
    <h2>Vouchers & Gifts</h2>
  </div>

    <?php foreach ($myVoucherList as $row):
       ?>

        <div class="col-lg-4 mb-3">
          <?php if ($row->type=="Discount"): ?>
            <div class="card voucher-discount">
          <?php endif; ?>
          <?php if ($row->type=="Gift"): ?>
            <div class="card voucher-gift">
          <?php endif; ?>
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <div class="voucher-title">
                    <?php if ($row->type=="Discount"): ?>
                      <?=format_money($row->discount)?> off
                    <?php endif; ?>
                    <?php if ($row->type=="Gift"): ?>
                      <?=$row->name?>
                    <?php endif; ?>
                  </div>
                  <div class="voucher-min-spend">
                    <?php if ($row->minimumSpend>0): ?>
                      Min. Spend: <?=format_money($row->minimumSpend)?>
                      <?php else: ?>
                        No Minimum Spend
                    <?php endif; ?>
                  </div>
                  <div class="voucher-expiring">
                    <?=days_hours_left($row->validUntil)?>
                  </div>
                </div>
                <div class="col">
                  <?php if (days_hours_left($row->validUntil)=="Expired"): ?>

                    <a href="#" class="btn btn-secondary mt-3">Use</a>
                    <?php else: ?>
                      <a href="../pages/process.php?action=use-voucher&voucherId=<?=$row->Id?>&store=<?=$store->storeCode?>" class="btn btn-primary mt-3">Use</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

    <?php endforeach; ?>

    <?php endif; ?>


    <?php if ($voucherList): ?>

      <div class="section-header mt3">
        <h2>Claimable Vouchers</h2>
      </div>

    <?php foreach ($voucherList as $row):
       ?>

        <div class="col-lg-4 mb-3">
          <?php if ($row->type=="Discount"): ?>
            <div class="card voucher-discount">
          <?php endif; ?>
          <?php if ($row->type=="Gift"): ?>
            <div class="card voucher-gift">
          <?php endif; ?>
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <div class="voucher-title">
                    <?php if ($row->type=="Discount"): ?>
                      <?=format_money($row->discount)?> off
                    <?php endif; ?>
                    <?php if ($row->type=="Gift"): ?>
                      <?=$row->name?>
                    <?php endif; ?>
                  </div>
                  <div class="voucher-min-spend">
                    <?php if ($row->minimumSpend>0): ?>
                      Min. Spend: <?=format_money($row->minimumSpend)?>
                      <?php else: ?>
                        No Minimum Spend
                    <?php endif; ?>
                  </div>
                  <div class="voucher-expiring">
                    <?=days_hours_left($row->validUntil)?>
                  </div>
                </div>
                <div class="col">
                  <?php if (days_hours_left($row->validUntil)=="Expired"): ?>
                    <a href="#" class="btn btn-secondary mt-3">Claim</a>
                    <?php else: ?>
                          <a href="../pages/process.php?action=claim-voucher&voucherId=<?=$row->Id?>&custId=<?=$customer->Id?>&store=<?=$store->storeCode?>" class="btn btn-primary mt-3">Claim</a>
    
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

    <?php endforeach; ?>

    <?php endif; ?>


      </div>

    </div>
  </section><!-- End Menu Section -->


<?php include "templates/footer.php"; ?>
