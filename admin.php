<!DOCTYPE html>
<html lang="en">


	<!-- ==================  section Head ================== -->
	        <?php require_once("view/sections/admin/head.php") ;?>
<body>
	
<!-- ==================   Verivication section  ================== -->
<?php 

	session_start();
	if (!isset($_SESSION['email'])) {  
	header("Location: login?error=1&message=" . urlencode("Merci de connecter d'abord") . "&title=" . urlencode("Accès Interdit !"));
	exit; 
	}

?>
<!-- ==================  Section Loader  ================== -->

	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

	<!-- ==================  section Menu Heaut ================== -->
	        <?php require_once("view/sections/admin/menuHeaut.php") ;?>
		
	<!-- ================== section Menu Gauche ================== -->

		     <?php require_once("view/sections/admin/menuGauche.php") ;?>
		
	<!-- ==================  section Base Content ================== -->
	        <?php require_once("view/sections/admin/baseContent.php") ;?>
		
	<!-- ================== section config ================== -->
	        <?php require_once("view/sections/admin/config.php") ;?>
		
	<!-- ================== section scroll to top btn ================== -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	</div>
	    <?php require_once("view/sections/admin/script.php") ;?>

		<!-- ================== section Message Errur/Success ================== -->
		 <?php require_once("view/sections/admin/msgErrorSuccess.php") ;?>



</body>
</html>