<?php
  include "templates/header-store.php";

  $category_list = menuCategory()->list("storeId=$store->Id");

  $date = get_query_string("date", date("Y-m-d"));
  $totalConfirmed = orderMain()->count("status='Confirmed' and storeCode='$store->storeCode' and date='$date'");
?>

<main id="main">

  <section id="menu" class="menu">
    <div class="container">

      <div class="section-header">
        <h2>Notification</h2>
      </div>

      <button type="button" id="activateButton" class="btn btn-primary text-center" onclick="activateNotif()">Click to Activate Receiver</button>
      <h1 class="text-center" id="receiver" style="display:none">Stay here to receive notification</h1>

      <div class="alert alert-danger" role="alert" id="alertBar" style="display:none;" onclick="location.href='store-orders.php?status=Pending'">
          <span id="totalPending">0</span> new pending orders!
       </div>

       <hr>
       <?php if ($totalConfirmed): ?>
        <div class="alert alert-primary" role="alert"  onclick="location.href='store-orders.php?status=Confirmed'">
          <span id="totalPending"><?=$totalConfirmed;?></span> new confirmed orders!
       </div>
        <?php endif; ?>

     </div>
   </section>
 </main>

 <script type="text/javascript">
 var currentPending = 0;

 function activateNotif(){

     document.getElementById("activateButton").style.display = "none";
     document.getElementById("receiver").style.display = "";

     var intervalId = window.setInterval(function(){
       $.ajax({
           type: "GET",
           url: "api-pending-orders.php?storeName=<?=$storeName?>",
           success: function(data){
             const obj = JSON.parse(data);
             if (currentPending!=obj.totalPending) {
               document.getElementById("alertBar").style.display = "";
               document.getElementById("totalPending").innerHTML = obj.totalPending;
               currentPending = obj.totalPending;

               notificationSound();
             }
           }
         });
     }, 5000);
 }



 function notificationSound(){
   const audio = new Audio("templates/audio/notification.wav");
   audio.play();
 }

 </script>

<?php include "templates/footer.php"; ?>