
      </div>
    </div>
  </div>



  <script src="templates/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="templates/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="templates/assets/js/sidebarmenu.js"></script>
  <script src="templates/assets/js/app.min.js"></script>
  <script src="templates/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="templates/assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="templates/assets/js/dashboard.js"></script>


  <!-- product form -->

  <script src="templates/assets/form/select2.full.min.js"></script>
  <script src="templates/assets/form/select2.min.js"></script>
  <script src="templates/assets/form/select2.init.js"></script>
  <script src="templates/assets/form/jquery.repeater.min.js"></script>
  <script src="templates/assets/form/jquery.validate.min.js"></script>
  <script src="templates/assets/form/repeater-init.js"></script>


  <!-- modernize -->

  <!-- <script src="templates/assets/modernize/vendor.min.js"></script> -->
  <!-- Import Js Files -->
  <!-- <script src="templates/assets/modernize/bootstrap.bundle.min.js"></script> -->
  <!-- <script src="templates/assets/modernize/simplebar.min.js"></script> -->
  <!-- <script src="templates/assets/modernize/app.init.js"></script> -->
  <!-- <script src="templates/assets/modernize/theme.js"></script> -->
  <!-- <script src="templates/assets/modernize/app.min.js"></script> -->
  <!-- <script src="templates/assets/modernize/sidebarmenu.js"></script> -->

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="templates/assets/modernize/apexcharts.min.js"></script>
  <script src="templates/assets/modernize/dashboard2.js"></script>


</body>

</html>


<script type="text/javascript">
$(function () {

  <?php if ($success): ?>
    Swal.fire({
      title: "Success!",
      text: "<?=$success?>",
      icon: "success"
    });
  <?php endif; ?>


  <?php if ($error): ?>
    Swal.fire({
      title: "Error!",
      text: "<?=$error?>",
      icon: "error"
    });
  <?php endif; ?>


  });

  
  function deleteNotification(proccessUrl) {
      Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = proccessUrl;
    }
  });
      }

</script>
