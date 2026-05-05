<?php 

require_once(__DIR__ . "/UserController.php");  

$UserController = new UserController();

// Authentifier un utilisateur
if (isset($_POST['frmLogin'])) {
    $UserController->auth();
}

// Déconnecter un utilisateur
if (isset($_GET['logout'])) {
    $UserController->logout();
}

// Créer un utilisateur
if (isset($_POST['frmAddUser'])) {
    $UserController->registerUser();
}

// Changer le mot de passe
if (isset($_POST['frmChangePassword'])) {
    $UserController->changePassword();
}

// Suppression un utilisateur
if (
    $_SERVER['REQUEST_METHOD'] === 'GET'
    && isset($_GET['id'], $_GET['action'])
    && $_GET["action"] === 'supprimer'  // ✅ "supprimer" au lieu de "delete"
) {
    $UserController->desactivateUtilisateur();
}

// Restauration un utilisateur
if (
    $_SERVER['REQUEST_METHOD'] === 'GET'
    && isset($_GET['id'], $_GET['action'])
    && $_GET["action"] === 'restaurer'
) {
    $UserController->activateUtilisateur();
}

// Modifier un utilisateur
if (isset($_POST['frmEditUser'])) {
    $UserController->editUser();
}


//Envoié mail reinitialition passeword
if (isset($_POST['frmreinitConfirmMail'])) {
    $UserController->sendMailConfirmUser();
}

    // Reinitialisation du passeword 
    if (isset($_POST['frmreinitPassWord'])) {
        $UserController->reinitPassword();
    }
?>