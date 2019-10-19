<?php

    // Le fichier appelé Model, correspond à l'interaction avec la BDD

    class ForumModel extends CoreModel {

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
        //----------------------METHODE READ ALL CATEGORIES---------------------------
        //----------------------------------------------------------------------------
        public function readAllCategories(){
            
            try {
                if (($this->_req = $this->getDb()->query('SELECT 
                                                         `for_category_id` AS `id`,
                                                         `for_category_name` AS `name`
                                                         FROM `forum_category`
                                                         ')) !== false) {
                    
                    if (($this->_req->execute()) !== false) {

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
        //----------------------METHODE READ ONE CATEGORY-----------------------------
        //----------------------------------------------------------------------------
        public function readOneCategory($idCategory){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `for_category_id` AS `id`,
                                                         `for_category_name` AS `name`
                                                         FROM `forum_category`
                                                         WHERE `for_category_id` = ?
                                                         ')) !== false) {
                    
                    if (($this->_req->execute([$idCategory])) !== false) {

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
        //----------------------METHODE READ ALL SUB-CATEGORIES-----------------------
        //----------------------------------------------------------------------------
        public function readAllSubCategories(){
            
            try {
                if (($this->_req = $this->getDb()->query('SELECT 
                                                         `for_subcategory_id` AS `id`,
                                                         `for_subcategory_name` AS `name`,
                                                         `for_subcategory_desc` AS `desc`,
                                                         `for_subcategory_picto` AS `picto`,
                                                         `for_cat_fk` AS `category`
                                                         FROM `forum_subcategory`
                                                         ')) !== false) {
                    
                    if (($this->_req->execute()) !== false) {

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
        //----------------------METHODE READ ONE SUB-CATEGORY-------------------------
        //----------------------------------------------------------------------------
        public function readOneSubCategory($idSubCat){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `for_subcategory_id` AS `id`,
                                                         `for_subcategory_name` AS `name`,
                                                         `for_subcategory_desc` AS `desc`,
                                                         `for_subcategory_picto` AS `picto`,
                                                         `for_cat_fk` AS `category`
                                                         FROM `forum_subcategory`
                                                         WHERE `for_subcategory_id` = ?
                                                         ')) !== false) {
                    
                    if (($this->_req->execute([$idSubCat])) !== false) {

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
        //---------------------------METHODE READ LAST TOPIC--------------------------
        //----------------------------------------------------------------------------
        public function readLastTopic($id){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                             `for_topic_id` AS `id`,
                                                         `for_topic_subject` AS `subject`,
                                                         `for_topic_content` AS `content`,
                                                         `for_topic_date` AS `date`,
                                                         `for_topic_statut` AS `statut`,
                                                         `for_topic_usr_fk` AS `UserId`,
                                                         `for_topic_subcat_fk` AS `subcategory`
                                                            FROM `forum_topic`
                                                        WHERE `for_topic_subcat_fk` = ?
                                                        ORDER BY `for_topic_date` DESC
                                                            LIMIT 0,1')) !== false) {
                    
                    if (($this->_req->execute([$id])) !== false) {

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
        //------------------------------METHODE NB TOPICS-----------------------------
        //----------------------------------------------------------------------------
        public function nbTopics($idSubCat){
            try {

                if (($this->_req = $this->getDb()->prepare('SELECT `for_subcategory_id` 
                                                            FROM `forum_subcategory` 
                                                            JOIN `forum_topic` ON `forum_subcategory`.`for_subcategory_id` = `forum_topic`.`for_topic_subcat_fk`
                                                            WHERE `for_subcategory_id` = ?')) !== false){

                if (($this->_req->execute([$idSubCat])) !== false) {
                    
                    $nbTopics = $this->_req->rowcount();
                    return $nbTopics;
                }
            }
            } catch(PDOException $e){
                
                die($e->getMessage());        
            }
        }

        //----------------------------------------------------------------------------
        //------------------------METHODE NB TOPICS BY USER---------------------------
        //----------------------------------------------------------------------------
        public function nbTopicsByUser($idUser){
            try {

                if (($this->_req = $this->getDb()->prepare('SELECT `for_topic_id` 
                                                            FROM `forum_topic` 
                                                            JOIN `user` ON `forum_topic`.`for_topic_usr_fk` = `user`.`usr_id`
                                                            WHERE `for_topic_usr_fk` = ?')) !== false){

                if (($this->_req->execute([$idUser])) !== false) {
                    
                    $nbTopics = $this->_req->rowcount();
                    return $nbTopics;
                }
            }
            } catch(PDOException $e){
                
                die($e->getMessage());        
            }
        }

        
        //----------------------------------------------------------------------------
        //--------------------------METHODE READ ALL TOPICS---------------------------
        //----------------------------------------------------------------------------
        public function readAllTopics($idSubCategory){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `for_topic_id` AS `id`,
                                                         `for_topic_subject` AS `subject`,
                                                         `for_topic_content` AS `content`,
                                                         `for_topic_date` AS `date`,
                                                         `for_topic_statut` AS `statut`,
                                                         `for_topic_usr_fk` AS `User`,
                                                         `for_topic_subcat_fk` AS `subcategory`
                                                         FROM `forum_topic`
                                                         WHERE `for_topic_subcat_fk` = ?
                                                         ORDER BY `for_topic_date` DESC
                                                         ')) !== false) {
                    
                    if (($this->_req->execute([$idSubCategory])) !== false) {

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
        //-------------------------------METHODE ADD TOPIC----------------------------
        //----------------------------------------------------------------------------
        public function addTopic($subject, $content, $user, $subcategory){
            
            try {
                if (($this->_req = $this->getDb()->prepare('INSERT INTO `forum_topic` 
                                                            (`for_topic_subject`, 
                                                            `for_topic_content`, 
                                                            `for_topic_date`, 
                                                            `for_topic_usr_fk`, 
                                                            `for_topic_subcat_fk`) 
                                                            VALUES (?, ?, NOW(), ?, ?)')) !== false) {
                    
                    if (($this->_req->execute([$subject, $content, $user, $subcategory])) !== false) {

                        // $msg = 'Votre Sujet a bien été créé';
                        // return $msg;

                        return $this->getDb()->lastInsertId();

                    } else {
                        
                        $msg = 'Une erreur est survenue lors de la création de votre sujet';
                        return $msg;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //----------------------------METHODE NB MESSAGES-----------------------------
        //----------------------------------------------------------------------------
        public function nbMessages($idTopic){
            try {

                if (($this->_req = $this->getDb()->prepare('SELECT `for_msg_id` 
                                                            FROM `forum_msg` 
                                                            JOIN `forum_topic` ON `forum_msg`.`for_msg_topic_fk` = `forum_topic`.`for_topic_id`
                                                            WHERE `for_topic_id` = ?')) !== false){

                if (($this->_req->execute([$idTopic])) !== false) {
                    
                    $nbMessages = $this->_req->rowcount();
                    return $nbMessages;
                }
            }
            } catch(PDOException $e){
                
                die($e->getMessage());        
            }
        }

        //----------------------------------------------------------------------------
        //---------------------------METHODE READ LAST MESSAGE------------------------
        //----------------------------------------------------------------------------
        public function readLastMessage($idTopic){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                           `for_msg_id` AS `id`,
                                                           `for_msg_date` AS `date`,
                                                           `for_msg_content` AS `content`,
                                                           `for_msg_usr_fk` AS `user`,
                                                           `for_msg_topic_fk` AS `topic`
                                                            FROM `forum_msg`
                                                            WHERE `for_msg_topic_fk` = ?
                                                            ORDER BY `for_msg_date` DESC
                                                            LIMIT 0,1')) !== false) {
                    
                    if (($this->_req->execute([$idTopic])) !== false) {

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
        //------------------------------METHODE SEND MESSAGE--------------------------
        //----------------------------------------------------------------------------
        public function addMessage($content, $user, $topic){
            
            try {
                if (($this->_req = $this->getDb()->prepare('INSERT INTO `forum_msg` 
                                                            (`for_msg_date`, 
                                                            `for_msg_content`, 
                                                            `for_msg_usr_fk`, 
                                                            `for_msg_topic_fk`) 
                                                            VALUES (NOW(), ?, ?, ?)')) !== false) {
                    
                    if (($this->_req->execute([$content, $user, $topic])) !== false) {

                        $msg = 'Votre message a bien été ajouté';
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
        //---------------------------METHODE READ ALL MESSAGES------------------------
        //----------------------------------------------------------------------------
        public function readAllMessages($idTopic){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                           `for_msg_id` AS `id`,
                                                           `for_msg_date` AS `date`,
                                                           `for_msg_content` AS `content`,
                                                           `for_msg_usr_fk` AS `user`,
                                                           `for_msg_topic_fk` AS `topic`
                                                            FROM `forum_msg`
                                                            WHERE `for_msg_topic_fk` = ?')) !== false) {
                    
                    if (($this->_req->execute([$idTopic])) !== false) {

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
        //------------------------------METHODE ONE TOPIC-----------------------------
        //----------------------------------------------------------------------------
        public function readOneTopic($id){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                             `for_topic_id` AS `id`,
                                                         `for_topic_subject` AS `subject`,
                                                         `for_topic_content` AS `content`,
                                                         `for_topic_date` AS `date`,
                                                         `for_topic_statut` AS `statut`,
                                                         `for_topic_usr_fk` AS `user`,
                                                         `for_topic_subcat_fk` AS `subcategory`
                                                            FROM `forum_topic`
                                                        WHERE `for_topic_id` = ?')) !== false) {
                    
                    if (($this->_req->execute([$id])) !== false) {

                        $datas = $this->_req->fetch(PDO::FETCH_ASSOC);

                        return $datas;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

    }
?>