<?php


require_once("DbRepository.php");
class UserRepository extends DbRepository
{

    // Permet de créer un compt de l'utilisateur
    public function register($nom, $adresse, $telephone, $photo, $email, $password, $role, $createdBy)
    {
        $sql = "INSERT INTO users (nom, adresse, telephone, photo, email, password, role, etat, created_at, created_by)
      VALUES (:nom, :adresse, :telephone, :photo, :email, :password, :role, default, NOW(), :created_by) ";
        try {

            $statement = $this->db->prepare($sql);
           $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $statement->execute([
                'nom' => $nom,
                'adresse' => $adresse,
                'telephone' => $telephone,
                'photo' => $photo,
                'email' => $email,
                'password' => $hashPassword,
                'role' => $role,
                'created_by' => $createdBy
            ]);

            $lastInsertId = $this->db->lastInsertId();
            return $lastInsertId ?: null;
        } catch (PDOException $error) {
            error_log("Erreur lors de la création de compt utilisateur " . $error->getMessage());
            throw $error;
        }
    }

    //Permet d'authentifier un utilisateur
     public function login($email, $password)
      {

         $sql = "SELECT * FROM users WHERE email = :email AND  etat = 1";

         try {
            $statement = $this->db->prepare($sql);
            // $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute(['email' => $email]);
             $users = $statement->fetch(PDO::FETCH_ASSOC);
             if ($users && password_verify($password, $users['password'])) {
                return $users;
             }
                return false;

         } catch (PDOException $error) {
            error_log("Erreur lors de la connexion de l'utilisateur " . $error->getMessage());
            throw $error;
         }
      }

}

?>