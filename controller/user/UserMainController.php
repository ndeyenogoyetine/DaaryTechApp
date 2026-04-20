<?php 

require_once(__DIR__ . "/UserController.php");  

   $UserController = new UserController();

    if (isset($_POST['frmLogin'])) {
        $UserController->auth();
    }


?>