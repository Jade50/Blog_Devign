<?php

    // Le fichier appelé Model, correspond à l'interaction avec la BDD

    class MessageModel extends CoreModel {

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
        //--------------------------METHODE SEND MESSAGE------------------------------
        //----------------------------------------------------------------------------
        public function sendMessage($content, $userFrom, $convId){
            
            try {
                if (($this->_req = $this->getDb()->prepare('INSERT INTO `message` 
                                                        (`msg_content`, 
                                                        `msg_usr_fk`,
                                                        `msg_conv_fk`, 
                                                        `msg_date`) 
                                                        VALUES (?, ?, ?, NOW())')) !== false) {
                    
                    if (($this->_req->execute([$content, $userFrom, $convId])) !== false) {

                        $msg = 'Votre message a bien été envoyé';
                        return $msg;
                    } else {
                        $msg = 'Une erreur est survenue lors de l\'envoi de votre message';
                        return $msg;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //----------------------METHODE READ ALL MESSAGES-----------------------------
        //----------------------------------------------------------------------------
        public function readAllMessages($idConv){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `msg_id` AS `id`,
                                                         `msg_content` AS `message`,
                                                         `msg_usr_fk` AS `userfrom`,
                                                         `msg_conv_fk` AS `conv`,
                                                         `msg_date` AS `date`
                                                         FROM `message`
                                                         WHERE `msg_conv_fk` = ?
                                                         ORDER BY `msg_date`')) !== false) {
                    
                    if (($this->_req->execute([$idConv])) !== false) {

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
        //-----------------------------METHODE NB MESSAGES----------------------------
        //----------------------------------------------------------------------------
        public function nbMessages($idConv){
            try {

                if (($this->_req = $this->getDb()->prepare('SELECT `msg_id` 
                                                            FROM `message` 
                                                            WHERE `msg_conv_fk` = ?')) !== false){

                if (($this->_req->execute([$idConv])) !== false) {
                    
                    $nbMessages = $this->_req->rowcount();
                    return $nbMessages;
                }
            }
            } catch(PDOException $e){
                
                die($e->getMessage());        
            }
        }

                //----------------------------------------------------------------------------
        //---------------------------METHODE READ LAST ARTICLE------------------------
        //----------------------------------------------------------------------------
        public function readLastMessage($idConv){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                            `msg_id` AS `id`,
                                                            `msg_content` AS `message`,
                                                            `msg_usr_fk` AS `userfrom`,
                                                            `msg_conv_fk` AS `conv`,
                                                            `msg_date` AS `date`
                                                            FROM `message`
                                                            WHERE `msg_conv_fk` = ?
                                                            ORDER BY `msg_date` DESC
                                                            LIMIT 0,1')) !== false) {
                    
                    if (($this->_req->execute([$idConv])) !== false) {

                        $message = $this->_req->fetch(PDO::FETCH_ASSOC);

                        return $message;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

    }
?>