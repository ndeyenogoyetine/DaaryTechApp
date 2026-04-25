    <?php
    session_start();

    require_once("ServiceReaController.php");

    $serviceReaController = new ServiceReaController();
    // Ajout d'un service/ralisation 
    if (isset($_POST['frmAddServiceRea'])) {
        $serviceReaController->addServiceRea();
    }

    // Suppretion d'un service/ralisation 
    if (
        $_SERVER['REQUEST_METHOD'] === 'GET'
        && isset($_GET['id'], $_GET['action'])
        && $_GET["action"] === 'delete'
    ) {
        $serviceReaController->desactivateServiceRea();
    }

   // Restauration d'un service/ralisation 
    if (
        $_SERVER['REQUEST_METHOD'] === 'GET'
        && isset($_GET['id'], $_GET['action'])
        && $_GET["action"] === 'restaurer'
    ) {
        $serviceReaController->activateServiceRea();
    }

    // Suppréssion devinitivement d'un service/ralisation 
    if (
        $_SERVER['REQUEST_METHOD'] === 'GET'
        && isset($_GET['id'], $_GET['action'])
        && $_GET["action"] === 'delete-definitive'
    ) {
        $serviceReaController->deleteServiceRea();
    }
    // Edition d'un service/ralisation 
    if (isset($_POST['frmEditServiceRea'])) {
        $serviceReaController->editServiceRea();
    }
    ?>