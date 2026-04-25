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


    //Permet d'ajouter  un service ou une realisation dans la BD  
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
                $this->setErrorAndRedirect("Tous les champs sont obligatoires.", "Erreur de l' ajout");
            }

            // Validation du type 
            if (!in_array($type ,['R', 'S'])) {
                $this->setErrorAndRedirect("Le type est sélectionné est invalide.", "Erreur de l' ajout");
            }

            //Validation de la photo
            if (!$photo || $photo['error'] !== UPLOAD_ERR_OK) {
                $this->setErrorAndRedirect("Une erreur est survenue lors du téléchargement de la photo.","Erreur de l' ajout");
            }

            //   Récupération de la photo Uploding(Téléchargement de la photo)
            $uploadDir = "../../public/images/servicesRea/";
            $photoName = uniqid() . "_" . basename($photo['name']);
            $uploadPath = $uploadDir . $photoName;

            // Déplacement de la photo dans servicesRea
            if (!move_uploaded_file($photo['tmp_name'], $uploadPath)) {
                $this->setErrorAndRedirect("Echec du téléchargement de l'image.", "Erreur de l' ajout");
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
                       $this->setErrorAndRedirect("Une erreur estsurvenue lors de l'ajout." ,"Erreur de l' ajout");
                    }
            } catch (Exception $error) {
                       $this->setErrorAndRedirect("Erreur" . $error->getMessage(), "Erreur de l' ajout");
            }
        }
    }
  
   //Permet de désactiver un service ou une realisation dans la BD  
   public function desactivateServiceRea()
   {
    $id =intval($_GET['id']);
    $deletedBy = $_SESSION['id'] ?? null;
    $etatUser = $_SESSION['etat'] ?? null;

    // Verification de l'etat de l'utilisateur
    if ($etatUser !== 1) {
       $this->setSuccessAndRedirect("Votre compte n'est  pas actif","Accés non autorisé", "login");
    }

    // Verification des données
    if (empty($id) || empty($deletedBy)) {
       $this->setSuccessAndRedirect("Imposible de désactiver cette realisation","Information manquantes");
    }

    // Appelle du repository pour désactiver
    try {
        $result = $this->serviceReaRepository->desactivate($id, $deletedBy);
        if ($result) {
           $this->setSuccessAndRedirect("Realisation/service supprimé(e) avec succés", "Suppression réussie");
        }
    } catch (Exception $error) {
     $this->setSuccessAndRedirect("Erreur lors de la supperssion" .$error->getMessage(), "Erreur de supprétion");
    }
   }
       
    //Permet d'activation un service ou une realisation dans la BD  
   public function activateServiceRea()
   {
    $id =intval($_GET['id']);
    $updatedBy = $_SESSION['id'] ?? null;
    $etatUser = $_SESSION['etat'] ?? null;

    // Verification de l'etat de l'utilisateur
    if ($etatUser !== 1) {
       $this->setSuccessAndRedirect("Votre compte n'est  pas actif","Accés non autorisé", "login");
    }

    // Verification des données
    if (empty($id) || empty($updatedBy)) {
       $this->setSuccessAndRedirect("Imposible d'activer cette realisation","Information manquantes");
    }

    // Appelle du repository pour désactiver
    try {
        $result = $this->serviceReaRepository->activate($id, $updatedBy);
        if ($result) {
           $this->setSuccessAndRedirect("Realisation/service restaurée avec succés", "Restauration réussie");
        }
    } catch (Exception $error) {
     $this->setSuccessAndRedirect("Erreur lors de la Restauration " .$error->getMessage(), "Erreur de Restauration");
    }
   }

   //Permet suppermer définitivement un service ou une realisation dans la BD  
   public function deleteServiceRea()
   {
    $id =intval($_GET['id']);
    $etatUser = $_SESSION['etat'] ?? null;

    // Verification de l'etat de l'utilisateur
    if ($etatUser !== 1) {
       $this->setSuccessAndRedirect("Votre compte n'est  pas actif","Accés non autorisé", "login");
    }

    // Verification des données
    if (empty($id)) {
       $this->setSuccessAndRedirect("Imposible de supprimer definitiviement cette realisation ","Information manquantes");
    }

    // Appelle du repository pour désactiver
    try {
        $result = $this->serviceReaRepository->delete($id);
        if ($result) {
           $this->setSuccessAndRedirect("Realisation/service supprimé avec succés", "Suppréssion réussie");
        }
    } catch (Exception $error) {
     $this->setSuccessAndRedirect("Erreur lors de la Suppréssion définitive " .$error->getMessage(), "Erreur de Suppréssion");
    }
   }

   
    //Permet Modifier  un service ou une realisation dans la BD  
    public function editServiceRea()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            //recupération des données du formulaire
            $id = intval($_POST['edit-id'] ?? '');
            $nom = trim($_POST['edit-nom'] ?? '');
            $description = trim($_POST['edit-description'] ?? '');
            $type = trim($_POST['edit-type'] ?? '');
            $updatedBy =  $_SESSION["id"] ?? null;
            $photo = $_FILES['edit-photo'] ?? null;


            //Validation des Données
            if (empty($nom) || empty($description) || empty($type) === UPLOAD_ERR_NO_FILE) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoires.", "Erreur de modification");
            }

            // Validation du type 
            if (!in_array($type ,['R', 'S'])) {
                $this->setErrorAndRedirect("Le type est sélectionné est invalide.", "Erreur de modification");
            }
            $allowedTypes = ['image/jpg', 'image/png', 'image/gif', 'image/avif'];

            //Validation de la photo
            $photoName = null;
            if ($photo) {
               //   Récupération de la photo Uploding(Téléchargement de la photo)
                $uploadDir = "../../public/images/servicesRea/";
                $photoName = uniqid() . "_" . basename($photo['name']);
                $uploadPath = $uploadDir . $photoName;

                // Déplacement de la photo dans servicesRea
                if (!move_uploaded_file($photo['tmp_name'], $uploadPath)) {
                    $this->setErrorAndRedirect("Echec du téléchargement de l'image.", "Erreur de modification");
                }
            }

            // Si aucune photo n'est choisie, conserver l'ancienne photo
            if (!$photoName) {
               $photoName =trim($photo['current-photo'] ?? '');
            }

            //Apple de la methode pour modifier dans la base de données
            try {
               
                $reponse = $this->serviceReaRepository->edit($id,$nom, $description, $photoName, $type, $updatedBy);
                
                if ($reponse) {
                    $msg = $type === 'R' ? "Réalisation modifier avec successe" : "Service  modifier avec successe" ;
                    $this->setSuccessAndRedirect($msg, "Modification réussi");
                    }                
                    else
                    {
                       $this->setErrorAndRedirect("Une erreur est survenue lors de la modification." ,"Erreur de modification");
                    }
            } catch (Exception $error) {
                       $this->setErrorAndRedirect("Erreur" . $error->getMessage(), "Erreur de modification");
            }
        }
    }
}

?>