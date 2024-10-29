<?php
  include "templates/header-store.php";



  $ratingList = ratings()->list("storeId=$store->Id order by Id desc");
  
?>

<main id="main">

    <section id="menu" class="menu">
        <div class="container">


            <div class="section-header">
                <h2>Customer's Feedback
                </h2>

            </div>

            <div class="row">
                <?php foreach ($ratingList as $row):
                    $order = orderMain()->get("Id=$row->orderId");
                    $customer = customer()->get("Id=$row->customerId");
                    ?>
                <div class="col-lg-4 col-md-6 mt-2" data-aos="fade-up">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col order-label">
                                    Date:
                                </div>
                                <div class="col order-value">
                                    <?=$row->dateAdded;?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col order-label">
                                    Order:
                                </div>
                                <div class="col order-value">
                                    <?=$order->orderNumber;?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col order-label">
                                    Ratings:
                                </div>
                                <div class="col order-value">
                                    <?=get_ratings($row->stars);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col order-label">
                                    Customer:
                                </div>
                                <div class="col order-value">
                                    <?=$customer->name;?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col order-label">
                                    Feedback:
                                </div>
                                <div class="col order-value">
                                    <?=$row->feedback;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>

            </div>

    </section>

</main>




<?php include "templates/footer.php"; ?>