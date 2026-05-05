    <?php
    session_start();

    require_once("ContactController.php");

    $contactController = new ContactController();
    
    // Ajoute un contact dans la base de donnees 
    if (isset($_POST['frmContact'])) {
        $contactController->addContact();
    }


    ?>
    