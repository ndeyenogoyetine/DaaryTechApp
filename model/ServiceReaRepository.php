<?php
require_once("DbRepository.php");

class ServiceReaRepository extends DbRepository
{
    // Récupérer la liste des réalisations et Services
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
            $etatLabel = $etat == 1 ? "actives" : "supprimés";
            error_log("Erreur lors de la récupération des services $etatLabel : " . $error->getMessage());
            throw $error;
        }
    }

    // Récupérer la liste par état et type
    public function getAllByEtatAndType(int $etat, string $type)
    {
        $sql = "SELECT * FROM service_reas WHERE etat = :etat AND type = :type";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['etat' => $etat, 'type' => $type]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $error) {
            $etatLabel = $etat == 1 ? "actives" : "supprimés";
            $typeLabel  = $type == "R" ? "réalisation" : "services";
            error_log("Erreur lors de la récupération des $typeLabel $etatLabel : " . $error->getMessage());
            throw $error;
        }
    }

    // Récupérer une réalisation/service par id
    public function getServiceReaById(int $id)
    {
        $sql = "SELECT * FROM service_reas WHERE id = :id";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['id' => $id]); 
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $error) {
            error_log("Erreur lors de la récupération de l'id $id : " . $error->getMessage());
            throw $error;
        }
    }

    // Ajouter une réalisation/service
    public function add($nom, $description, $photo, $type, $createdBy)
    {
        $sql = "INSERT INTO service_reas (nom, description, photo, etat, type, created_at, created_by)
                VALUES (:nom, :description, :photo, 1, :type, NOW(), :created_by)";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute([
                'nom'         => $nom,
                'description' => $description,
                'photo'       => $photo,
                'type'        => $type,
                'created_by'  => $createdBy
            ]);
            return $this->db->lastInsertId() ?: null;
        } catch (PDOException $error) {
            error_log("Erreur lors de l'ajout de $nom : " . $error->getMessage());
            throw $error;
        }
    }

    // Modifier une réalisation/service
    public function edit($id, $nom, $description, $photo, $type, $updated_by)
    {
        $sql = "UPDATE service_reas
                SET nom = :nom, description = :description, photo = :photo,
                    type = :type, updated_at = NOW(), updated_by = :updated_by
                WHERE id = :id";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute([
                'nom'         => $nom,
                'description' => $description,
                'photo'       => $photo,
                'type'        => $type,
                'updated_by'  => $updated_by,
                'id'          => $id
            ]);
            return $statement->rowCount() > 0;
        } catch (PDOException $error) {
            error_log("Erreur lors de la modification de $nom : " . $error->getMessage());
            throw $error;
        }
    }

    // Désactiver une réalisation/service
    public function desactivate($id, $deleteBy)
    {
        $sql = "UPDATE service_reas
                SET etat = 0, deleted_at = NOW(), deleted_by = :deleted_by
                WHERE id = :id";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['deleted_by' => $deleteBy, 'id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $error) {
            error_log("Erreur lors de la désactivation de l'id $id : " . $error->getMessage());
            throw $error;
        }
    }

    // Activer une réalisation/service
    public function activate($id, $updated_by)
    {
        $sql = "UPDATE service_reas
                SET etat = 1, updated_at = NOW(), updated_by = :updated_by
                WHERE id = :id";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['updated_by' => $updated_by, 'id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $error) {
            error_log("Erreur lors de l'activation de l'id $id : " . $error->getMessage());
            throw $error;
        }
    }

    // Supprimer définitivement une réalisation/service
    public function delete(int $id)
    {
        $sql = "DELETE FROM service_reas WHERE id = :id"; 
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['id' => $id]); 
            return $statement->rowCount() > 0;
        } catch (PDOException $error) {
            error_log("Erreur lors de la suppression de l'id $id : " . $error->getMessage());
            throw $error;
        }
    }
}