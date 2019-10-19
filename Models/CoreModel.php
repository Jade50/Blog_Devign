<?php

    // On définie la class CoreModel en abstract car nous n'aurons pas besoin de l'instancier.
    // Ce sont les class Model qui hériteront de celle-ci afin de récupérer la connexion à la BDD
    abstract class CoreModel {

        // On définie toutes les propriétés privées de la BDD en leur affectant la valeur des constantes du fichier ini
        private $_engine = DB_ENGINE;
        private $_host = DB_HOST;
        private $_dbname = DB_NAME;
        private $_charset = DB_CHARSET;
        private $_user = DB_USER;
        private $_pwd = DB_PWD;

        // Propriété de la BDD
        private $_db;

        // à l'instanciation du CoreModel, la fonction de connexion à la BDD se lance
        public function __construct(){

            $this->connect();
        }

        private function connect(){
            
            try{
                $dsn = $this->_engine.':host='.$this->_host.';dbname='.$this->_dbname.';charset='.$this->_charset;

                // On passe à notre propriété DB la connexion
                $this->_db = new PDO($dsn, $this->_user, $this->_pwd, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        // Fonction qui retourne la propriété DB qui contient la connexion à la BDD
        protected function getDb(){
            return $this->_db;
        }

    }

?>