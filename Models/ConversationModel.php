<?php

    // Le fichier appelé Model, correspond à l'interaction avec la BDD

    class ConversationModel extends CoreModel {

        // Je défini une propriété db et req pour la connexion à la BDD et pour les requêtes
        // private $_db;
        private $_req;

        // Quand il n'y a plus de référence sur un objet donné, le destructeur de la class se déclenche
        public function __destruct(){

            // ici je lui demande, si ma requête sql n'est pas vide
            if (!empty($this->_req)) {
                //alors je ferme l'exécution de la requête
                $this->_req->closeCursor();
            }
        }

        //----------------------------------------------------------------------------
        //---------------------------CONVERSATION EXISTS------------------------------
        //----------------------------------------------------------------------------
        public function searchConversation($userFrom, $userTo){
            
            try {
                if (($this->_req = $this->getDb()->query("SELECT `cov_id`
                                                            FROM `conversation`
                                                            WHERE `cov_usr_one` = $userFrom
                                                            AND `cov_usr_two` = $userTo
                                                            OR `cov_usr_one` = $userTo
                                                            AND `cov_usr_two` = $userFrom")) !== false) {
                    
                    if (($this->_req->execute()) !== false) {

                        $datas = $this->_req->fetch(PDO::FETCH_ASSOC);

                        return $datas;
                    } 
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //---------------------METHODE READ ONE CONVERSATION--------------------------
        //----------------------------------------------------------------------------
        public function readOneConversation($idConv){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `cov_id` AS `id`,
                                                         `cov_usr_one` AS `userone`,
                                                         `cov_usr_two` AS `usertwo`
                                                         FROM `conversation`
                                                         WHERE `cov_id` = ?
                                                         ')) !== false) {
                    
                    if (($this->_req->execute([$idConv])) !== false) {

                        $datas = $this->_req->fetch(PDO::FETCH_ASSOC);

                        return $datas;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        
        //----------------------------------------------------------------------------
        //-------------------------------METHODE ADD COMMENT----------------------------
        //----------------------------------------------------------------------------
        public function addConversation($userFrom, $userTo){
            
            try {
                if (($this->_req = $this->getDb()->prepare('INSERT INTO `conversation` 
                                                            (`cov_usr_one`, 
                                                            `cov_usr_two`) 
                                                            VALUES (?, ?)')) !== false) {
                    
                    if (($this->_req->execute([$userFrom, $userTo])) !== false) {

                        $idNewConv = $this->getDb()->lastInsertId();
                        return $idNewConv;
                    } 
                }

                return false;

            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }


        //----------------------------------------------------------------------------
        //-----------------------METHODE READ ALL CONVERSATIONS-----------------------
        //----------------------------------------------------------------------------
        public function readAllConversations($idUser){
            
            try {
                if (($this->_req = $this->getDb()->prepare("SELECT 
                                                           `cov_id` AS `id`,
                                                           `cov_usr_one` AS `userone`,
                                                           `cov_usr_two` AS `usertwo`
                                                            FROM `conversation`
                                                            WHERE `cov_usr_one` = ?
                                                            OR `cov_usr_two` = ?
                                                            ORDER BY `cov_id` ASC")) !== false) {
                    
                    if (($this->_req->execute([$idUser, $idUser])) !== false) {

                        $datas = $this->_req->fetchAll(PDO::FETCH_ASSOC);

                        return $datas;
                    }
                }
                return false;

            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //-------------------------NB CONVERSATIONS BY USER---------------------------
        //----------------------------------------------------------------------------
        public function nbConversationsByUser($idUser){
            
            try {
                if (($this->_req = $this->getDb()->query("SELECT `cov_id`
                                                            FROM `conversation`
                                                            WHERE `cov_usr_one` = $idUser
                                                            OR `cov_usr_two` = $idUser")) !== false) {
                    
                    if (($this->_req->execute()) !== false) {

                        $nbConversations = $this->_req->rowcount();
                        return $nbConversations;
                    } 
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }
       
    }
?>