<?php 

require_once(__DIR__ . "/NewsletterController.php");  

$newsletterController = new NewsletterController();
$newsletterRepository = new NewsletterRepository();

// Ajout newsletter
if (isset($_POST['frmAddNewsletter'])) {
    $newsletterController->addNewsletter();
}

//  Envoi message  newsletter
if (isset($_POST['frmSendMessage'])) {
    $message = $_POST["message"];
    
    $listeNewsletters = $newsletterRepository->getAll();

    if (empty($listeNewsletters)) {
        $message = "Aucun abonné trouvé dans la base de bonnées";

        $_SESSION["error"] = $message;
        header("Location: listeNewsletter?error=1&message=" . urlencode($message) . "&title=" . "Newsletter");
        exit;
    }
    foreach ($listeNewsletters as $newsletter) {
        $newsletterController->sendMessageMail($newsletter['email'], $message);
       
    }
        $messageSuccess = "Message envoié avec succès";
        header("Location: listeNewsletter?succes=1&message=" . urlencode($messageSuccess) . "&title=" . urlencode($title));
        exit;
    
}


?>
