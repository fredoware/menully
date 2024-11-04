

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../pages/templates/source/bootstrap.bundle.min.js"></script>
  <script src="../pages/templates/source/aos.js"></script>
  <script src="../pages/templates/source/glightbox.min.js"></script>
  <script src="../pages/templates/source/purecounter_vanilla.js"></script>
  <script src="../pages/templates/source/swiper-bundle.min.js"></script>
  <script src="../pages/templates/source/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../pages/templates/source/main.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

</body>

</html>

<script type="text/javascript">
<?php if ($success): ?>
	Swal.fire({
		title: "Success",
		text: "<?=$success;?>",
		icon: "success"
		});
<?php endif; ?>


<?php if ($error): ?>
	Swal.fire({
		title: "Error",
		text: "<?=$error;?>",
		icon: "error"
		});
<?php endif; ?>
</script>
