<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../../model/ContactRepository.php");
class ContactController
{
    private $contactRepository;

    public function __construct()
    {
        $this->contactRepository = new ContactRepository();
    }

        // Permet de faire la gestion des messages erreurs
    public function setErrorAndRedirect($message, $title, $redirectUrl = "index.php")

    {
        $_SESSION["error"] = $message;
        header("Location: $redirectUrl?error=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;

    }

    // Permet de faire la gestion des messages success
    public function setSuccessAndRedirect($message, $title, $redirectUrl = "index.php")

    {
        $_SESSION["succes"] = $message;
        header("Location: $redirectUrl?succes=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;

    }


    
    //Permet d'ajouter  un contact dans la BD  
    public function addContact()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            //recupération des données du formulaire
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $sujet = trim($_POST['sujet'] ?? '');
            $message =  trim($_POST['message'] ?? '');

            //Validation des Données
            if (empty($nom) || empty($email) || empty($sujet) || empty($message)) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoires.", "Message non envoyé.");
            }
            
             // Validation l'email 
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setErrorAndRedirect("L'adresse email est invalide.", "Message non envoyé.");
            }


            //Apple de la methode pour insérer dans la base de données
            try {
                

                // Juste avant $this->serviceReaRepository->add(...)
               
                $reponse = $this->contactRepository->add($nom, $email, $sujet ,$message);
                
                if ($reponse) {
                    $this->setSuccessAndRedirect("Message envoyé avec success", "Envoi réussi");
                    }                
                    else
                    {
                       $this->setErrorAndRedirect("Une erreur est survenue lors de l'envoi du message." ,"Message non envoyé.");
                    }
            } catch (Exception $error) {
                       $this->setErrorAndRedirect("Erreur" . $error->getMessage(), "Erreur de l'envoi");
            }
        }
    }
  
}
?>