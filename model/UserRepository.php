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

        // Récupérer la liste  users
        public function getAll(int $etat, ?string $role = null)
        {
            $sql = "SELECT u.*,
                        u1.email as created_by_email,
                        u2.email as updated_by_email
                    FROM users u
                    LEFT JOIN users u1 ON u.created_by = u1.id
                    LEFT JOIN users u2 ON u.updated_by = u2.id
                    WHERE u.etat = :etat";

                  if ($role) {
                   $sql .= " AND u.role = :role ";
                  }
            try {
                $statement = $this->db->prepare($sql);
                $params = ['etat' => $etat];
                if ($role) {
                   $params["role"] = $role;
                }
                $statement->execute($params);

                return  $statement->fetchAll(PDO::FETCH_ASSOC) ?: null;
            } catch (PDOException $error) {
                $etatLabel = $etat == 1 ? "actives" : "supprimés";
                error_log("Erreur lors de la récupération des $etatLabel" . $error->getMessage());
                throw $error;
            }
        }

        // Récupérer user via sont id
        public function getByid(int $id)
        {
            $sql = "SELECT * FROM users WHERE id = :id";

            try {

                $statement = $this->db->prepare($sql);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                 $statement->execute();
             return  $statement->fetch(PDO::FETCH_ASSOC) ?: null;

            } catch (PDOException $error) {
                error_log("Erreur lors de la récupération de l'utilisateurs $id" . $error->getMessage());
                throw $error;
            }
        }

         // Récupérer user via sont id
        public function getUserByEmail(string $email)
        {
            $sql = "SELECT * FROM users WHERE email = :email";

            try {

                $statement = $this->db->prepare($sql);
                $statement->execute(['email' => $email]);
             return  $statement->fetch(PDO::FETCH_ASSOC) ?: null;

            } catch (PDOException $error) {
                error_log("Erreur lors de la récupération de l'utilisateurs d'email $email" . $error->getMessage());
                throw $error;
            }
        }

        // Modifier une user/service
        public function edit( $id, $nom, $adresse, $telephone, $photo, $email, $role, $updated_by)
        {
            $sql = "UPDATE users
                    SET nom = :nom, adresse= :adresse, telephone = :telephone, photo = :photo,
                    email = :email, role = :role , updated_at = NOW(), updated_by = :updated_by
                    WHERE id = :id";

            try {
                $statement = $this->db->prepare($sql);
                $statement->execute([
                    'nom'         => $nom,
                    'adresse' => $adresse,
                    'telephone' => $telephone,
                    'photo'       => $photo,
                    'email'        => $email,
                    'role'        => $role,
                    'updated_by'  => $updated_by,
                    'id'          => $id
                ]);
                $rowAffected = $statement->rowCount();
                return $rowAffected >= 0; // trus si $rowffecvted > 0
            } catch (PDOException $error) {
                error_log("Erreur lors de la modification de l'utilisateur $nom : " . $error->getMessage());
                throw $error;
            }
        }

        //  Désactiver une user
        public function desactivate($id, $deleteBy)
        {
            $sql = "UPDATE users
                    SET etat = 0, deleted_at = NOW(), deleted_by = :deleted_by
                    WHERE id = :id";

            try {
                $statement = $this->db->prepare($sql);
                $statement->execute(['deleted_by' => $deleteBy, 'id' => $id]);
                return $statement->rowCount() > 0; 
            } catch (PDOException $error) {
                error_log("Erreur lors de la désactivation de l'utilisateur l'id $id : " . $error->getMessage());
                throw $error;
            }
        }

        // Activer une user
        public function activate($id, $updated_by)
        {
            $sql = "UPDATE users
                    SET etat = 1, updated_at = NOW(), updated_by = :updated_by
                    WHERE id = :id";

            try {
                $statement = $this->db->prepare($sql);
                $statement->execute(['updated_by' => $updated_by, 'id' => $id]);
                return $statement->rowCount() > 0;
            } catch (PDOException $error) {
                error_log("Erreur lors de l'activation de  l'utilisateur l'id $id : " . $error->getMessage());
                throw $error;
            }
        }


            public function updatePassword($userId, $hashPassword)
        {
            // ✅ Correction : updated_by au lieu de deleted_by
            $sql = "UPDATE users
                    SET password = :password, updated_at = NOW(), updated_by = :updated_by
                    WHERE id = :id";

            try {
                $statement = $this->db->prepare($sql);
                $statement->execute([
                    'password'   => $hashPassword,
                    'updated_by' => $userId,
                    'id'         => $userId
                ]);
                return $statement->rowCount() > 0;
            } catch (PDOException $error) {
                error_log("Erreur lors de la modification du mot de passe: " . $error->getMessage());
                throw $error;
            }
        }
   }



?>