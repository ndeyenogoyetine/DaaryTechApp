<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

session_start();
require_once("../../model/UserRepository.php");
require_once("../newsletter/NewsletterController.php");
require "../../vendor/autoload.php";

class UserController
{
    private $userRepository;
    private $newslatterController;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->newslatterController = new NewsletterController();

    }

    // Permet de valider l'email et le password
    public function validateLoginFields($email, $password)
    {
        if (empty($email) || empty($password)) {
            return "Tous les champs sont obligatoires.";
        }
    //    Validation l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "L'email fourni est invalide.";
        }
        return null;
    }

    // Permet de faire la gestion des erreurs
    public function setErrorAndRedirect($message, $title, $redirectUrl = "login")

    {
        $_SESSION["error"] = $message;
        header("Location: $redirectUrl?error=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    public function setSuccessAndRedirect($message, $title, $redirectUrl = "admin")

    {
        $_SESSION["succes"] = $message;
        header("Location: $redirectUrl?succes=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }


    // Permet d'authentifier le super administrateur
    public function authSuperAdmin($email, $password)

    {
        if ($email === "tine@gmail.com" && $password === "tine2003") {
            $_SESSION["id"] = 1;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = "Admin";
            $_SESSION["nom"] = "Nogoye tine";
            $_SESSION["etat"] = 1;

            $this->setSuccessAndRedirect("Bienvenue sur le dashboard admin", "Connexion réussie");
        }
        return false;
    }

    // Permet d'authentifier un administrateur
    public function authAdmin($email, $password, $userRepository)

    {
        $user = $userRepository->login($email, $password);
        if ($user &&  $user['etat'] == 1) {
            $_SESSION["id"]    = $user['id'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["nom"]   = $user['nom'];
            $_SESSION["etat"] = $user['etat'];
            $_SESSION["photo"] = $user['photo'];


            if (isset($_POST['remember'])) {
                setcookie('remember_me', $user['id'], time() + 86400 * 30, '/', '', false, true);
            }
            $this->setSuccessAndRedirect("Bienvenue sur le dashboard admin", "Connexion réussie");
        } else {
            $this->setErrorAndRedirect("Votre compte à été désactiver.", "Accés non autorisé.");
        }
        return false;
    }

    //Authentification
    function auth()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email    = trim($_POST['email']    ?? '');
            $password = trim($_POST['password'] ?? '');

            // Validation des champs
            $messageError = $this->validateLoginFields($email, $password);
            if ($messageError) {
                $this->setErrorAndRedirect($messageError, "Erreur de connexion");
            }

            // Vérifie si c'est un super admin
            if ($this->authSuperAdmin($email, $password)) {
                exit;
            }

            // Authentification classique des admins via la méthode login()
            if (!$this->authAdmin($email, $password, $this->userRepository)) {
                $this->setErrorAndRedirect("Identifiants incorrects", "Erreur de connexion");
            }
        }
    }

    // Premet de déconnecter un administrateur
    public function logout()
    {
        // Sppression des variables de sessions
        session_unset();
        session_destroy();

        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3000, '/', '', false, true);
        }

        $this->setSuccessAndRedirect("Vous avez été déconnecté avec succés", " Déconnexion réussie", "home");
    }

    // Permet de générer un mot de passe par défaut
    private function generateDefaultPassword($length = 8)
    {
        $chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        $chaineLength = strlen($chaine); //62
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) { //8 fois pardéfaut
            $randomPassword .= $chaine[rand(0, $chaineLength - 1)];
        }
        return $randomPassword;
    }

    // Permet d'envoyer un e-mail contenant les udentifiants de connexion(email et password)
    function sendPassewordEmail($email, $password)
    {
        $mail = new PHPMailer(true);

        try {
            //Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'ca2eb2645c82b1';
            $mail->Password = 'a7da459681e741';
            $mail->Port = 2525;

            //Expéditeur et destinataire
            $mail->setFrom('no-replye@daaraytechnologie.com', "Daaray Technologie");
            $mail->addAddress($email, "Utilisateur");


            // Contenu de l'e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Bienvenue sur la plateforme Daaray technologie';
            $mail->Body =
                "
                        <h1>Bienvenue <b>{$email}</b>! </h1>
                        <p>{$password} :</p>
                        <ul>
                        <li>Email : <strong>{$email}</strong></li>
                        <li>Mot de Passe : <strong>{$password}</strong></li>
                        </ul>
                        <p>Merci de vous connecte pour commencer.</p>
                     ";

              $email->AltBody = "Bravo.Vouci vos identifiant Email : {$email}, Mot de passe : {$password}";

            // Envoi de l'email
            $mail->send();
            echo "Email envoyé avec succés à " . $email;
        } catch (Exception $error) {
            echo "Erreur lors de l'envoi de l'e-maile : {$mail->ErrorInfo}";
        }
    }

    // Permet d'enrégistre un utilisateur
    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données
            $nom = trim($_POST['user-nom'] ?? '');
            $adresse = trim($_POST['user-adresse'] ?? '');
            $telephone = trim($_POST['user-telephone'] ?? '');
            $email = trim($_POST['user-email'] ?? '');
            $role = trim($_POST['user-role'] ?? 'Admin');
            $photo = $_FILES['user-photo'] ?? null;
            $createdBy = $_SESSION['id'] ?? null;


            // Génération du mot de passe par défaut
            $password = $this->generateDefaultPassword();

            // Vérifier si un user avec cet email existe déjà
            if ($this->userRepository->getUserByEmail($email)) {
                $this->setErrorAndRedirect("Cet e-mail est déjà utilisé", "Erreur de création de compte", "listeUser");
            }

            // Validation des données
            if (empty($nom) || empty($adresse) || empty($telephone) || empty($email)) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoire", "Erreur de création de compte", "listeUser");
            }

            // Validation du role 
            if (!in_array($role ,['Admin', 'Equipe'])) {
                $this->setErrorAndRedirect("Le role est sélectionné est invalide.", "Erreur de modification", "listeUser");
            }

            // Validation l'email 
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setErrorAndRedirect("L'adresse email est invalide.", "Erreur de création de compte", "listeUser");
            }


            // Validation du photo
            $photoName = null;
            if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
                $uploadDir = "../../public/images/users/";
                $photoName = uniqid() . "_" . basename($photo['name']);
                $uploadPath = $uploadDir . $photoName;
            }

            // Déplacement de la photo dans servicesRea
            if (!move_uploaded_file($photo['tmp_name'], $uploadPath)) {
                $this->setErrorAndRedirect("Echec du téléchargement de l'image.", "Erreur de création de comptet", "listeUser");
            }

            try {
                $userId = $this->userRepository->register($nom, $adresse, $telephone, $photoName, $email, $password, $role, $createdBy);

                if ($userId) {
                    $message = $role == 'Admin'
                        ? "Compte créé avec succès. Unmail contenant les idantifiants de connexion à été envoie"
                        : "Compte créé avec succès";

                    // Envoie du mail
                    if ($role == 'Admin') {
                        $this->sendPassewordEmail($email, $password);
                    }
                    $this->sendPassewordEmail($message, "Compte créé avec succès", "listeUser");
                }
            } catch (Exception  $error) {
                $this->setErrorAndRedirect("Erreur" . $error->getMessage(), "Erreur de création de comptet", "listeUser");
            }
        }
    }

    // Permet de changer le mot de passe un utilisateur
    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données
            $userId = $_SESSION['id'] ?? null;
            $currentPassword = trim($_POST['current_password'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmePassword = trim($_POST['confirme_password'] ?? '');

            // Vérifier si l'utilisateur est connecté
            if (!$userId) {
                $this->setErrorAndRedirect("Vous devez vous connecté d'abord pour changer votre mot de passe", "Accés non autorisé");
            }
            // Validation des données
            if (empty($currentPassword) || empty($newPassword) || empty($confirmePassword)) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoire", "Erreur de reinitialisation du password", "listeUser");
            }

            // Validation des 2 password
            if ($newPassword !== $confirmePassword) {
                $this->setErrorAndRedirect(
                    "Le nouveau mot de passe et le mot de passe de confirmation ne correspondent",
                    "Erreur de modification de password",
                    "listeUser"
                );
            }

            // Validation du newpassword
            if (strlen($newPassword) < 8) {
                $this->setErrorAndRedirect(
                    "Le nouveau mot de passe doit contenir au moins 8 caractères.",
                    "Erreur de modification de password",
                    "listeUser"
                );
            }

            try {
                $user = $this->userRepository->getByid($userId);

                if (!$user) {
                    $this->setErrorAndRedirect(
                        "Utilisateur non trouvé dans la base de donnée.",
                        "Erreur de modification de password",
                        "listeUser"
                    );
                }

                // Hachage du mot de passe
                $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Changement du mot de passe dans la base de données
                $this->userRepository->updatePassword($userId, $hashPassword);

                $this->setSuccessAndRedirect("Votre mot de passe à été changé avec succès", "Modification réussie", "listeUser");
            } catch (Exception $error) {
                $this->setSuccessAndRedirect("Une erreur est survenue lors de la modification du mot de passe :"
                    . $error->getMessage(), "Modification réussie", "listeUser");
            }
        }
    }

    //Permet désactiver un utilisateur dans la BD  
    public function desactivateUtilisateur()
    {
        $id = intval($_GET['id']);
        $deletedBy = $_SESSION['id'] ?? null;
        $etatUser = $_SESSION['etat'] ?? null;

        // Verification de l'etat de l'Utilisateur
        if ($etatUser !== 1) {
            $this->setSuccessAndRedirect("Votre compte n'est  pas actif", "Accés non autorisé", "login");
        }

        // Verification des données
        if ($id == 1) {
            $this->setSuccessAndRedirect("Imposible de supprimer le super admin", "Action non autorisée","listeUser");
        }

        // Appelle du repository pour désactiver
        try {
            $result = $this->userRepository->desactivate($id, $deletedBy);
            if ($result) {
                $this->setSuccessAndRedirect("Utilisateur suppermé avec succés", "Suppression réussie", "listeUser");
            }
        } catch (Exception $error) {
            $this->setSuccessAndRedirect("Erreur lors de la supperssion" . $error->getMessage(), "Erreur de supprétion","listeUser");
        }
    }

    //Permet d'activation unun utilisateur dans la BD  
    public function activateUtilisateur()
    {
        $id = intval($_GET['id']);
        $updatedBy = $_SESSION['id'] ?? null;
        $etatUser = $_SESSION['etat'] ?? null;

        // Verification de l'etat de l'utilisateur
        if ($etatUser !== 1) {
            $this->setSuccessAndRedirect("Votre compte n'est  pas actif", "Accés non autorisé", "login");
        }

        // Verification des données
        if (empty($id) || empty($updatedBy)) {
            $this->setSuccessAndRedirect("Imposible d'activer cette realisation", "Information manquantes","listeUser");
        }

        // Appelle du repository pour désactiver
        try {
            $result = $this->userRepository->activate($id, $updatedBy);
            if ($result) {
                $this->setSuccessAndRedirect("Utilisateur restaurée avec succés", "Restauration réussie","listeUser");
            }
        } catch (Exception $error) {
            $this->setSuccessAndRedirect("Erreur lors de la Restauration " . $error->getMessage(), "Erreur de Restauration","listeUser");
        }
    }

    //Permet de Modifier un utilisateur dans la BD  
    public function editUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            //recupération des données du formulaire
            $id = intval($_POST['edit-user-id'] ?? '');
            $nom = trim($_POST['edit-user-nom'] ?? '');
            $adresse = trim($_POST['edit-user-adresse'] ?? '');
            $telephone = trim($_POST['edit-user-telephone'] ?? '');
            $email = trim($_POST['edit-user-email'] ?? '');
            $role = trim($_POST['edit-user-role'] ?? 'Admin');
            $photo = $_FILES['edit-user-photo'] ?? null;
            $updated_by =  $_SESSION["id"] ?? null;



            //Validation des Données
            if (empty($nom) || empty($adresse) || empty($telephone) || empty($email) || empty($role) === UPLOAD_ERR_NO_FILE) { 
                $this->setErrorAndRedirect("Tous les champs sont obligatoires.", "Erreur de modification", "listeUser");
            }

            // Validation du role 
            if (!in_array($role ,['Admin', 'Equipe'])) {
                $this->setErrorAndRedirect("Le role est sélectionné est invalide.", "Erreur de modification","listeUser");
            }
            $allowedTypes = ['image/jpg', 'image/png', 'image/gif', 'image/avif'];

            //Validation de la photo
            $photoName = null;
            if ($photo) {
               //   Récupération de la photo Uploding(Téléchargement de la photo)
                $uploadDir = "../../public/images/users/";
                $photoName = uniqid() . "_" . basename($photo['name']);
                $uploadPath = $uploadDir . $photoName;

                // Déplacement de la photo dans users
                if (!move_uploaded_file($photo['tmp_name'], $uploadPath)) {
                    $this->setErrorAndRedirect("Echec du téléchargement de l'image.", "Erreur de modification","listeUser");
                }
            }

            // Si aucune photo n'est choisie, conserver l'ancienne photo
            if (!$photoName) {
               $photoName =trim($photo['current-photo'] ?? '');
            }

            //Apple de la methode pour modifier dans la base de données
            try {
               
                $reponse = $this->userRepository->edit( $id, $nom, $adresse, $telephone, $photoName, $email, $role, $updated_by);
                
                if ($reponse) {
                    
                    $this->setSuccessAndRedirect("U tilisateur modifier avec successe", "Modification réussie","listeUser");
                    }                
                    else
                    {
                       $this->setErrorAndRedirect("Une erreur est survenue lors de la modification." ,"Erreur de modification","listeUser");
                    }
            } catch (Exception $error) {
                       $this->setErrorAndRedirect("Erreur" . $error->getMessage(), "Erreur de modification");
            }
        }
    }

    // Permet d'envoyé un email de confirmation
   // Génère un code aléatoire à 6 chiffres
private function generateCode()
{
    return rand(100000, 999999);
}

    // Permet d'envoyer un email de confirmation
    public function sendMailConfirmUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = trim($_POST['confirmEmailReinit'] ?? '');

            // Validation des champs
            if (empty($email)) {
                $this->setErrorAndRedirect(
                    "L'adresse email est obligatoire.",
                    "Erreur de confirmation",
                    "reinitEmail"
                );
            }

            // Validation de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setErrorAndRedirect(
                    "L'email fourni est invalide.",
                    "Erreur de confirmation",
                    "reinitEmail"
                );
            }

            // Vérifier si l'utilisateur existe
            if (!$this->userRepository->getUserByEmail($email)) {
                $this->setErrorAndRedirect(
                    "Cet email est introuvable.",
                    "Erreur de confirmation",
                    "reinitEmail"
                );
            }

            // ✅ Génération du code (plus d'appel récursif)
            $code = $this->generateCode();
            $_SESSION['code'] = $code;
            $_SESSION['reinit_email'] = $email;

            $message = "<a href='http://localhost/DaarayTecApp/reinit?code=$code&$email=$email'>Merci de
                            Cliquez ici pour réinitialiser votre mot de passe
                        </a>";

            $this->newslatterController->sendMessageMail($email, $message);

            $this->setSuccessAndRedirect(
                "Email de réinitialisation envoyé avec succès",
                "Réinitialisation mot de passe",
                "reinitEmail"
            );
        }
    }

    
    // Permet de Reinitialiser le mot de passe un utilisateur
    public function reinitPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmePassword = trim($_POST['confirme_password'] ?? '');

           $code = $_SESSION['code'];

            // Validation des données
            if ( empty($newPassword) || empty($confirmePassword)) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoire",
                 "Erreur de modification de password", 
                "reinit?code=$code");
            }

            // Validation des 2 password
            if ($newPassword !== $confirmePassword) {
                $this->setErrorAndRedirect(
                    "Le nouveau mot de passe et le mot de passe de confirmation ne correspondent",
                    "Erreur de reinitialisation du password",
                    "reinit?code=$code"
                );
            }

            // Validation du newpassword
            if (strlen($newPassword) < 8) {
                $this->setErrorAndRedirect(
                    "Le nouveau mot de passe doit contenir au moins 8 caractères.",
                    "Erreur de reinitialisation du password",
                    "reinit?code=$code"
                );
            }

            try {
                $user = $this->userRepository->getUserByEmail($_SESSION['reinit_email']);

                if (!$user) {
                    $this->setErrorAndRedirect(
                        "Utilisateur non trouvé dans la base de donnée.",
                        "Erreur de reinitialisation du password",
                        "reinit?code=$code"
                    );
                }

                // Hachage du mot de passe
                $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Changement du mot de passe dans la base de données
                $this->userRepository->updatePassword($user['id'], $hashPassword);
                // envoie mail
                $this->sendPassewordEmail($user['nom'],$user['email'],"Votre mot de passe à été reinitialisé avec succès");

                $this->setSuccessAndRedirect("Votre mot de passe à été reinitialisé avec succès",
                 "Reinitialisation réussie", 
                 "login");

            } catch (Exception $error) {
                $this->setErrorAndRedirect("Une erreur est survenue lors de la reinitialisation du mot de passe :"
                    . $error->getMessage(), "Reinitialisation réussie",
                     "reinit?code=$code");
            }
        }
    }

  }  

