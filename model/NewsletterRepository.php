<?php


    require_once("DbRepository.php");
    class NewsletterRepository extends DbRepository
    {
     
        // Récupérer la liste  newsletters
        public function getAll()
        {
            $sql = "SELECT * FROM newsletters";
                       
            try {
                return  $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
              

            } catch (PDOException $error) {
                error_log("Erreur lors de la récupération des newsletters " . $error->getMessage());
                throw $error;
            }
        }

        // Récupérer newsletters via sont id
        public function getByEmail(string $email)
        {
            $sql = "SELECT * FROM newsletters WHERE email = :email";

            try {

                $statement = $this->db->prepare($sql);
                $statement->execute(['email' => $email]);
             return  $statement->fetch(PDO::FETCH_ASSOC) ?: null;

            } catch (PDOException $error) {
                error_log("Erreur lors de la récupération de la newsletter  d'email $email" . $error->getMessage());
                throw $error;
            }
        }

        //   Ajouter une newsletters
   // Ajouter une newsletter
public function add($email)
{
    $sql = "INSERT INTO newsletters (email, created_at)
            VALUES (:email, NOW())";

    try {
        $statement = $this->db->prepare($sql);
        $statement->execute(['email' => $email]);
        return $this->db->lastInsertId() ?: null;
    } catch (PDOException $error) {
        error_log("Erreur lors de l'ajout de la newsletter $email : " . $error->getMessage());
        throw $error;
    }
}

   }

?>