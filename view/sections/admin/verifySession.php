<?php 

	session_start();
	if (!isset($_SESSION['email'])) {  
	header("Location: login?error=1&message=" . urlencode("Merci de connecter d'abord") . "&title=" . urlencode("Accès Interdit !"));
	exit; 
	}

		$nom = $_SESSION["nom"];
		$email = $_SESSION["email"];

?>