<?php

   use LDAP\Result;

   require_once("DbRepository.php");
   class ServiceReaRepository extends DbRepository


   {

     //Recupérer la liste des réalisations ou les Services actives
     
      public function getAll(int $etat)
     {

            $sql = "SELECT sr.*,
                           u1.email as created_by_email,
                           u2.email as updated_by_email
                  FROM service_reas sr
                  LEFT JOIN users u1 ON sr.created_by = u1.id
                  LEFT JOIN users u2 ON sr.updated_by = u2.id
                  WHERE sr.etat = :etat";

         try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['etat' => $etat]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: null;
         } catch (PDOException $error) {
            $etatLabel = $etat == "1" ? "actives" : "supprimés";
            error_log("Erreur lors de la recupération / servicesdes  $etatLabel" . $error->getMessage());
            throw $error;
         }
      }
  

      //Recupérer la liste des réalisations ou les Services actives
      public function getAllByEtatAndType(int $etat, string $type)
      {

         $sql = "SELECT * FROM service_reas WHERE etat = :etat and type = :type";

         try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['etat' => $etat, 'type' => $type]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: null;
         } catch (PDOException $error) {
            $etatLabel = $etat == "1" ? "actives" : "supprimés";
            $typeLabel = $type == "R" ? "réalisation" : "services";

            error_log("Erreur lors de la recupération / servicesdes $typeLabel $etatLabel" . $error->getMessage());
            throw $error;
         }
      }

      //Recupérer une réalisation ou une Service via son id
      public function getServiceReaById(int $id)
      {

         $sql = "SELECT * FROM service_reas WHERE id = :id";

         try {
            $statement = $this->db->prepare($sql);
            // $statement->bindParam(":id", $id, PDO::PARAM_INT);
            // $statement->execute([ 'id'=> $id]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
         } catch (PDOException $error) {
            error_log("Erreur lors de la recupération de la réalisation / service d'id  $id" . $error->getMessage());
            throw $error;
         }
      }

      //Ajoute une nouvelle Réalisation 
      public function add($nom, $description, $photo, $type, $createdBy)
      {
         
         $sql = "INSERT INTO service_reas (nom, description, photo, etat, type, created_at, created_by)
            VALUES (:nom, :description, :photo, 1, :type, NOW(), :created_by)";
        
         try {

            $statement = $this->db->prepare($sql);
            $statement->execute([
               'nom' => $nom,
               'description' => $description,
               'photo' => $photo,
               'type' => $type,
               'created_by' => $createdBy

               
            ]);

            $lastInsertId = $this->db->lastInsertId();
            return $lastInsertId ?: null;
         } catch (PDOException $error) {
            error_log("Erreur lors de l'ajout de la réalisation / services $nom " . $error->getMessage());
            throw $error;
         }
      }

      // Permet de Modofier  une nouvelle Réalisation 
      public function edit($id, $nom, $description, $photo, $type, $updated_by)
      {
         $sql = "UPDATE service_reas
        SET nom= :nom, description = :description, photo = :photo, type = :type,
        updated_at = NOW(), updated_by = :updated_by WHERE id = :id ";
         try {

            $statement = $this->db->prepare($sql);
            $statement->execute([
               'nom' => $nom,
               'description' => $description,
               'photo' => $photo,
               'type' => $type,
               'updated_by' => $updated_by,
               'id' => $id
            ]);

            $rowAffected = $statement->rowCount();
            return $rowAffected > 0; // true si $rowAffected > 0
         } catch (PDOException $error) {
            error_log("Erreur lors de la modification de la réalisation / services $nom " . $error->getMessage());
            throw $error;
         }
      }

        //Permet dactiver une réalisation ou un Service via son id
      public function desactiver($id, $deleteBy)
      {

         $sql = "UPDATE service_reas
          SET etat = 0, deleted_at = NOW(), deleted_by = :deleted_by WHERE id = :id";

         try {
            $statement = $this->db->prepare($sql);
            // $statement->bindParam(":id", $id, PDO::PARAM_INT);
            // $statement->execute([ 'id'=> $id]);
            $result = $statement->execute(['deleted_by' => $deleteBy,'id' => $id]);
             $rowAffected = $statement->rowCount();
            return $rowAffected > 0;

         } catch (PDOException $error) {
            error_log("Erreur lors de la  désactivation de la réalisation / service d'id    $id" . $error->getMessage());
            throw $error;
         }
      }

        //Permet d'activer une réalisation ou un Service via son id
      public function activer($id, $updated_by)
      {

         $sql = "UPDATE service_reas
          SET etat = 1, updated_at = NOW(), updated_by = :updated_by WHERE id = :id";

         try {
            $statement = $this->db->prepare($sql);
            // $statement->bindParam(":id", $id, PDO::PARAM_INT);
            // $statement->execute([ 'id'=> $id]);
            $result = $statement->execute(['updated_by' => $updated_by,'id' => $id]);
             $rowAffected = $statement->rowCount();
            return $rowAffected > 0;

         } catch (PDOException $error) {
            error_log("Erreur lors de l'activation de la réalisation / service d'id    $id" . $error->getMessage());
            throw $error;
         }
      }

      //Permet de suppermer définitivement une réalisation ou un Service via son id
      public function delete(int $id)
      {

         $sql = "DELETE * FROM service_reas WHERE id = :id";

         try {
            $statement = $this->db->prepare($sql);
            // $statement->bindParam(":id", $id, PDO::PARAM_INT);
            // $statement->execute([ 'id'=> $id]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
         } catch (PDOException $error) {
            error_log("Erreur lors de la Suppression devinitive de la réalisation  / service d'id  $id" . $error->getMessage());
            throw $error;
         }
      }
   }

 ?>