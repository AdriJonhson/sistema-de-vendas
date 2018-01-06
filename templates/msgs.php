<script>
	setTimeout(function(){ document.getElementById('alert').style.display = 'none'}, 5000);	
</script>

<?php if(isset($_SESSION['msgErro'])){ ?>

	<div class="alert alert-danger" role="alert" id="alert">
		<?= $_SESSION['msgErro']; ?>
		<?php unset($_SESSION['msgErro']) ?>
	</div>

<?php } ?>


<?php if(isset($_SESSION['msgSuce'])){ ?>

	<div class="alert alert-success" role="alert" id="alert">
		<?= $_SESSION['msgSuce']; ?>
		<?php unset($_SESSION['msgSuce']) ?>
	</div>

<?php } ?>