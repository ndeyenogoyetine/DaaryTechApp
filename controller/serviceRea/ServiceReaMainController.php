<?php
session_start();

require_once("ServiceReaController.php");

$serviceReaController = new ServiceReaController();

if (isset($_POST['frmAddServiceRea'])) {
    $serviceReaController->addServiceRea();
}

?>