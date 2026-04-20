<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../../model/ServiceReaRepository.php");
class ServiceReaController
{
    private $serviceReaRepository;

    public function __construct()
    {
        $this->serviceReaRepository = new ServiceReaRepository();
    }

    // Permet de faire la gestion des messages erreurs
    public function setErrorAndRedirect($message, $title, $redirectUrl = "listeServiceRea")

    {
        $_SESSION["error"] = $message;
        header("Location: $redirectUrl?error=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;

    }

    // Permet de faire la gestion des messages success
    public function setSuccessAndRedirect($message, $title, $redirectUrl = "listeServiceRea")

    {
        $_SESSION["succes"] = $message;
        header("Location: $redirectUrl?succes=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;

    }


    //Permet d'ajouter un serviceRea dans la BD
    public function addServiceRea()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            //recupération des données du formulaire
            $nom = trim($_POST['nom'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $createdBy =  $_SESSION["id"] ?? null;
            $photo = $_FILES['photo'] ?? null;


            //Validation des Données
            if (empty($nom) || empty($description) || empty($type) || $photo['error'] === UPLOAD_ERR_NO_FILE) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoires.", "Erreur d'ajout");
            }

            // Validation du type 
            if (!in_array($type ,['R', 'S'])) {
                $this->setErrorAndRedirect("Le type est sélectionné est invalide.", "Erreur d'ajout");
            }

            //Validation de la photo
            if (!$photo || $photo['error'] !== UPLOAD_ERR_OK) {
                $this->setErrorAndRedirect("Une erreur est survenue lors du téléchargement de la photo.","Erreur d'ajout");
            }

            //   Récupération de la photo Uploding(Téléchargement de la photo)
            $uploadDir = "../../public/images/servicesRea/";
            $photoName = uniqid() . "_" . basename($photo['name']);
            $uploadPath = $uploadDir . $photoName;

            // Déplacement de la photo dans servicesRea
            if (!move_uploaded_file($photo['tmp_name'], $uploadPath)) {
                $this->setErrorAndRedirect("Echec du téléchargement de l'image.", "Erreur d'ajout");
            }

            //Apple de la methode pour insérer dans la base de données
            try {
                // Juste avant $this->serviceReaRepository->add(...)
               
                $reponse = $this->serviceReaRepository->add($nom, $description, $photoName, $type, $createdBy);
                
                if ($reponse) {
                    $msg = $type === 'R' ? "Réalisation ajouter avec successe" : "Service  ajouter avec successe" ;
                    $this->setSuccessAndRedirect($msg, "Ajout réussi");
                    }                
                    else
                    {
                       $this->setErrorAndRedirect("Une erreur estsurvenue lors de l'ajout." ,"Erreur d'ajout");
                    }
            } catch (Exception $error) {
                       $this->setErrorAndRedirect("Erreur" . $error->getMessage(), "Erreur d'ajout");
            }
        }
    }
    
}

?>