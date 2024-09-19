<?php
include "templates/header.php";

$status = $_GET['status'];
$storeList = store()->list("status='$status'");

?>


<div class="card bg-light-info shadow-none position-relative overflow-hidden">
<div class="card-body px-4 py-3">
    <div class="row align-items-center">
    <div class="col-9">
        <h4 class="fw-semibold mb-8">Stores</h4>
    </div>
    <div class="col-3">
        <div class="text-center mb-n5">
        <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
        </div>
    </div>
    </div>
</div>
</div>


<a href="store-form.php" class="btn btn-primary mb-3">Add New Store +</a>


<div class="row">
    <?php foreach ($storeList as $row): ?> 
        <div class="col-4">
            <div class="card clickable" onclick="location.href='store-detail.php?Id=<?=$row->Id?>'">
                <div class="card-body text-center">
                    <img src="../media/<?=$row->logo?>" class="crop-box">
                    <h3 class="mt-2"><?=$row->name;?></h3>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>



<?php include "templates/footer.php"; ?>
