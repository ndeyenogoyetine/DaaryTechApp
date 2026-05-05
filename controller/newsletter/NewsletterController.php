<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

ini_set('display_errors', 1);
error_reporting(E_ALL);

// session_start(); // ✅ Ajouté

require_once("../../model/NewsletterRepository.php");
require "../../vendor/autoload.php";

class NewsletterController
{
    private $newsletterRepository;

    public function __construct()
    {
        $this->newsletterRepository = new NewsletterRepository();
    }

    // Permet de faire la gestion des messages erreurs
    public function setErrorAndRedirect($message, $title, $redirectUrl = "home") // ✅ URL corrigée
    {
        $_SESSION["error"] = $message;
        header("Location: $redirectUrl?error=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    // Permet de faire la gestion des messages success
    public function setSuccessAndRedirect($message, $title, $redirectUrl = "home") // ✅ URL corrigée
    {
        $_SESSION["succes"] = $message;
        header("Location: $redirectUrl?succes=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    // Permet d'ajouter une newsletter dans la BD

      public function addNewsletter()
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            // Récupération des données du formulaire
            $email = trim($_POST['newsletter-email'] ?? '');

            // Validation de l'email
            if (empty($email)) {
                $this->setErrorAndRedirect("L'email est obligatoire.", "Erreur d'inscription");
            }

            // Validation format email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setErrorAndRedirect("L'adresse email est invalide.", "Erreur d'inscription");
            }

            // Vérifier si l'email existe déjà ✅ Ajouté
            $existant = $this->newsletterRepository->getByEmail($email);
            if ($existant) {
                $this->setErrorAndRedirect("Cet email est déjà inscrit à la newsletter.", "Erreur d'inscription");
            }

            // Insertion dans la base de données
            try {
                $reponse = $this->newsletterRepository->add($email);

                if ($reponse) {
                    $this->setSuccessAndRedirect("Vous recevrez toutes nos nouvelles par mail.", "Inscription réussie");
                } else {
                    $this->setErrorAndRedirect("Une erreur est survenue lors de l'inscription.", "Erreur d'inscription");
                }
            } catch (Exception $error) {
                $this->setErrorAndRedirect("Erreur : " . $error->getMessage(), "Erreur d'inscription");
            }
        }
    }

    //  Permet d'envoyer un e-mail contenant les udentifiants de connexion(email et password)

    function sendMessageMail($email, $message)
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
            $mail->addAddress($email, " C'est un inscrit à la newsletter");


            // Contenu de l'e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Bienvenue sur la plateforme Daaray technologie';
            $mail->Body =
                     "
                        <h1>Bienvenue <b> {$email} </b> </h1>
                        <p>{$message}</p>
                        <ul>
                        <p>Merci de vous connecte pour commencer.</p>
                     ";

            // Envoi de l'email
            $mail->send();
        } catch (Exception $error) {
            echo "Erreur lors de l'envoi de l'e-maile : {$mail->ErrorInfo}";
        }
    }

}
?>