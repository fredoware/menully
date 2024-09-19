<?php
include "templates/header.php";

$Id = $_GET['Id'];
$store = store()->get("Id=$Id");
$peopleList = storePeople()->list("storeId=$Id order by role");

?>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>



<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Store Detail</h4>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="row">
        <div class="col-3 text-center"><img src="../media/<?=$store->logo?>" class="crop-box"></div>
        <div class="col-3 text-center p-3">
            <div id="qrcode-2" class="text-center"></div>
        </div>
            <div class="col-6">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Name:</b>
                        <span><?=$store->name;?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Phone:</b>
                        <span><?=$store->phone;?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Email:</b>
                        <span><?=$store->email;?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Address:</b>
                        <span><?=$store->address;?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>Theme:</b>
                        <span><?=$store->theme;?></span>
                    </li>


                    <li class="list-group-item d-flex justify-content-between p-3">
                        <b>People:</b>
                        <span>
                            <?php foreach ($peopleList as $row):
                                $account = account()->get("Id=$row->userId");
                                ?>
                            <i><?=$account->name;?> (<?=$row->role;?>),</i> 
                            <?php endforeach; ?>
                        </span>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<a href="store-categories.php?Id=<?=$store->Id?>" class="btn btn-primary">Manage Products</a>

<?php include "templates/footer.php"; ?>

<script type="text/javascript">
  var qrcode = new QRCode(document.getElementById("qrcode-2"), {
  	text: "https://menully.com/<?=$store->storeCode;?>/",
  	width: 200,
  	height: 200,
  	colorDark : "#000",
  	colorLight : "#ffffff",
  	correctLevel : QRCode.CorrectLevel.H
  });
  </script>