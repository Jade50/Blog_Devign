<?php

    // Le fichier appelé Model, correspond à l'interaction avec la BDD

    class CommentModel extends CoreModel {

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
        //-----------------------------METHODE NB COMMENTS----------------------------
        //----------------------------------------------------------------------------
        public function nbComments($idArticle){
            try {

                if (($this->_req = $this->getDb()->prepare('SELECT `com_id` 
                                                            FROM `comment` 
                                                            JOIN `post` ON `post`.`pst_id` = `comment`.`com_pst_fk`
                                                            WHERE `pst_id` = ?')) !== false){

                if (($this->_req->execute([$idArticle])) !== false) {
                    
                    $nbTopics = $this->_req->rowcount();
                    return $nbTopics;
                }
            }
            } catch(PDOException $e){
                
                die($e->getMessage());        
            }
        }

        //----------------------------------------------------------------------------
        //-----------------------METHODE READ ALL COMMENTS----------------------------
        //----------------------------------------------------------------------------
        public function readAllComments($idArticle){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `com_id` AS `id`,
                                                         `com_content` AS `content`,
                                                         `com_seen` AS `seen`,
                                                         `com_date` AS `date`,
                                                         `com_pst_fk` AS `article`,
                                                         `com_usr_fk` AS `user`
                                                         FROM `comment`
                                                         WHERE `com_pst_fk` = ?
                                                         ')) !== false) {
                    
                    if (($this->_req->execute([$idArticle])) !== false) {

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
        //-------------------------------METHODE ADD COMMENT----------------------------
        //----------------------------------------------------------------------------
        public function addComment($comment, $article, $user){
            
            try {
                if (($this->_req = $this->getDb()->prepare('INSERT INTO `comment` 
                                                            (`com_content`, 
                                                            `com_seen`, 
                                                            `com_date`, 
                                                            `com_pst_fk`, 
                                                            `com_usr_fk`) 
                                                            VALUES (?, 0, NOW(), ?, ?)')) !== false) {
                    
                    if (($this->_req->execute([$comment, $article, $user])) !== false) {

                        $msg = 'Votre commentaire a bien été ajouté, il sera visible quand le créateur de cet article l\'aura validé.';
                        return $msg;

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
        //-----------------------METHODE READ ALL COMMENTS----------------------------
        //----------------------------------------------------------------------------
        public function readCommentsToValidate($idUser){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `com_id` AS `id`,
                                                         `com_content` AS `content`,
                                                         `com_seen` AS `seen`,
                                                         `com_date` AS `date`,
                                                         `com_pst_fk` AS `article`,
                                                         `com_usr_fk` AS `user`
                                                         FROM `comment`
                                                         JOIN `post` 
                                                         ON `post`.`pst_id` = `comment`.`com_pst_fk`
                                                         WHERE `pst_usr_fk` = ? 
                                                         AND `com_seen` = 0  
                                                         ')) !== false) {
                    
                    if (($this->_req->execute([$idUser])) !== false) {

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
        //-----------------------METHODE VALIDATE COMMENT-----------------------------
        //----------------------------------------------------------------------------
        public function validateComment($idComment){
            
            try {
                if (($this->_req = $this->getDb()->prepare('UPDATE `comment`
                                                            SET `com_seen` = 1
                                                            WHERE `com_id` = ?')) !== false) {
                    
                    if (($this->_req->execute([$idComment])) !== false) {

                        $msg = 'Ce commentaire a bien été validé, il est désormais visible sur l\'article.';

                        return $msg;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //-----------------------METHODE DELETE COMMENT-----------------------------
        //----------------------------------------------------------------------------
        public function deleteComment($idComment){
            
            try {
                if (($this->_req = $this->getDb()->prepare('DELETE 
                                                            FROM `comment`
                                                            WHERE `com_id` = ?')) !== false) {
                    
                    if (($this->_req->execute([$idComment])) !== false) {

                        $msg = 'Ce commentaire a bien été supprimé';

                        return $msg;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

    }
?>