   <?php

   class DbRepository
   {
      private $host;
      private $dbname;
      private $user;
      private $password;
      protected $db;

      public function __construct()
      {
         $this->host = getenv(name: 'DB_HOST') ?: "localhost";
         $this->dbname = getenv(name: 'DB_NAME') ?: "daaraytechapp";
         $this->user = getenv(name: 'DB_USER') ?: "root";
         $this->password = getenv(name: 'DB_PASSEWORD') ?: "";
         $this->getConnexion();
      }
      
      // cet methode permet de se connecter à la base donnée

      private function getConnexion()
      {
         $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
         try {
            $this->db = new PDO(dsn: $dsn, username: $this->user, password: $this->password);
            $this->db->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $error) {
            error_log(message: "Erreur de connexion à la BD" . $error->getMessage());
            die("une erreur s'est survenue lore de la connexion à la base de bonné");
         }
         
      }
      
   }
   ?>