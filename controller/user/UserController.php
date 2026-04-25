<?php
    session_start();
    require_once("../../model/UserRepository.php");

    class UserController
    {
        private $userRepository;

        public function __construct()
        {
            $this->userRepository = new UserRepository();
        }

        // Permet de valider l'email et le password
        public function validateLoginFields($email, $password)

        {
            if (empty($email) || empty($password)) {
                return "Tous les champs sont obligatoires.";
            }
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
                if ($user &&  $user['etat'] == 1 ) {
                    $_SESSION["id"]    = $user['id'];
                    $_SESSION["email"] = $user['email'];
                    $_SESSION["nom"]   = $user['nom'];
                    $_SESSION["etat"] = $user['etat'];


                    if (isset($_POST['remember'])) {
                        setcookie('remember_me', $user['id'], time() + 86400 * 30, '/', '', false, true);
                    }
                $this->setSuccessAndRedirect("Bienvenue sur le dashboard admin", "Connexion réussie");
                
                }
                else
                {
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
                        setcookie('remember_me', '', time() -3000 , '/', '', false, true);
                    }

                 $this->setSuccessAndRedirect("Vous avez été déconnecté avec succés", " Déconnexion réussie", "home");

            }
    }
 ?>