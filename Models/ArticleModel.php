<?php

    // Le fichier appelé Model, correspond à l'interaction avec la BDD

    class ArticleModel extends CoreModel {

        // Je défini une propriété db et req pour la connexion à la BDD et pour les requêtes
        // private $_db;
        private $_req;

        // Quand il n'y a plus de référence sur un objet donné, le destructeur de la class se déclenche
        public function __destruct(){

            if (!empty($this->_req)) {
                //erme l'exécution de la requête
                $this->_req->closeCursor();
            }
        }

        //----------------------------------------------------------------------------
        //----------------------METHODE READ ALL CATEGORIES---------------------------
        //----------------------------------------------------------------------------
        public function readAllCategories(){
            
            try {
                if (($this->_req = $this->getDb()->query('SELECT 
                                                         `pst_category_id` AS `id`,
                                                         `pst_category_name` AS `name`,
                                                         `pst_category_desc` AS `desc`
                                                         FROM `post_category`
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
        public function readCategory($idCategory){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `pst_category_id` AS `id`,
                                                         `pst_category_name` AS `name`,
                                                         `pst_category_desc` AS `desc`
                                                         FROM `post_category`
                                                         WHERE `pst_category_id` = ?
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
        //---------------------------METHODE READ LAST ARTICLE------------------------
        //----------------------------------------------------------------------------
        public function readLastArticle($idCategory){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                           `pst_id` AS `id`,
                                                           `pst_title` AS `title`,
                                                           `pst_text` AS `text`,
                                                           `pst_date` AS `date`,
                                                           `pst_usr_fk` AS `user`,
                                                           `pst_category_fk` AS `category`
                                                            FROM `post`
                                                            WHERE `pst_category_fk` = ?
                                                            ORDER BY `pst_date` DESC
                                                            LIMIT 0,1')) !== false) {
                    
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
        //-----------------------------METHODE NB ARTICLES----------------------------
        //----------------------------------------------------------------------------
        public function nbArticles($idCategory){
            try {

                if (($this->_req = $this->getDb()->prepare('SELECT `pst_id` 
                                                            FROM `post` 
                                                            JOIN `post_category` ON `post_category`.`pst_category_id` = `post`.`pst_category_fk`
                                                            WHERE `pst_category_id` = ?')) !== false){

                if (($this->_req->execute([$idCategory])) !== false) {
                    
                    $nbArticles = $this->_req->rowcount();
                    return $nbArticles;
                }
            }
            } catch(PDOException $e){
                
                die($e->getMessage());        
            }
        }

        //----------------------------------------------------------------------------
        //-----------------------------METHODE NB ARTICLES BY USER----------------------------
        //----------------------------------------------------------------------------
        public function nbArticlesByUser($idUser){
            try {

                if (($this->_req = $this->getDb()->prepare('SELECT `pst_id` 
                                                            FROM `post` 
                                                            JOIN `user` ON `user`.`usr_id` = `post`.`pst_usr_fk`
                                                            WHERE `pst_usr_fk` = ?')) !== false){

                if (($this->_req->execute([$idUser])) !== false) {
                    
                    $nbArticles = $this->_req->rowcount();
                    return $nbArticles;
                }
            }
            } catch(PDOException $e){
                
                die($e->getMessage());        
            }
        }

        //----------------------------------------------------------------------------
        //-----------------------------METHODE NB ARTICLES----------------------------
        //----------------------------------------------------------------------------
        public function readLastImg($idArticle){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                           `img_pst_id` AS `id`,
                                                           `img_pst_fk` AS `article`,
                                                           `img_pst_photo` AS `photoname`
                                                            FROM `img_post`
                                                            WHERE `img_pst_fk` = ?
                                                            ORDER BY `img_pst_id` DESC
                                                            LIMIT 0,1')) !== false) {
                    
                    if (($this->_req->execute([$idArticle])) !== false) {

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
        //---------------------------METHODE READ LAST ARTICLE------------------------
        //----------------------------------------------------------------------------
        public function readAllArticlesByCategory($idCategory, $depart, $articlesByPage){
            
            try {
                if (($this->_req = $this->getDb()->prepare("SELECT 
                                                           `pst_id` AS `id`,
                                                           `pst_title` AS `title`,
                                                           `pst_text` AS `text`,
                                                           `pst_date` AS `date`,
                                                           `pst_usr_fk` AS `user`,
                                                           `pst_category_fk` AS `category`
                                                            FROM `post`
                                                            WHERE `pst_category_fk` = ?
                                                            ORDER BY `pst_date` DESC LIMIT $depart, $articlesByPage")) !== false) {
                    
                    if (($this->_req->execute([$idCategory])) !== false) {

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
        public function readOneArticle($idArticle){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `pst_id` AS `id`,
                                                         `pst_title` AS `title`,
                                                         `pst_text` AS `text`,
                                                         `pst_date` AS `date`,
                                                         `pst_usr_fk` AS `user`,
                                                         `pst_category_fk` AS `category`
                                                         FROM `post`
                                                         WHERE `pst_id` = ?
                                                         ')) !== false) {
                    
                    if (($this->_req->execute([$idArticle])) !== false) {

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
        //------------------------METHODE READ ALL PHOTOS-----------------------------
        //----------------------------------------------------------------------------
        public function readAllImg($idArticle){
            
            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                         `img_pst_id` AS `id`,
                                                         `img_pst_fk` AS `article`,
                                                         `img_pst_photo` AS `photoname`
                                                         FROM `img_post`
                                                         WHERE `img_pst_fk` = ?
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
        //------------------------METHODE READ ALL PHOTOS-----------------------------
        //----------------------------------------------------------------------------
        public function addArticle($title, $text, $category, $user){
            
             if (($this->_req = $this->getDb()->prepare('INSERT INTO `post` 
                                                            (`pst_title`, 
                                                            `pst_text`, 
                                                            `pst_date`, 
                                                            `pst_usr_fk`, 
                                                            `pst_category_fk`) 
                                                            VALUES (?, ?, NOW(), ?, ?)')) !== false ) {

                if (($this->_req->execute([$title, $text, $user, $category])) !== false) {
                    
                    $idNewPost = $this->getDb()->lastInsertId();
                    // Je compte le nombre d'images uploadés
                    $nbPhotos = count($_FILES['imgs']['name']);
                    
                    // Pour chaque photo
                    for ($i=0; $i < $nbPhotos; $i++) { 
                        
                        // j'initialise son nom
                        $photoName = $_FILES['imgs']['name'][$i];
                        // Je crée un tableau d'extensions valides
                        $validExtensions = ['.png', '.jpg', '.jpeg', '.jpeg'];
                        // Je converti l'extension en minuscule
                        $extension = strtolower(strrchr($photoName, '.'));

                        if (in_array($extension, $validExtensions)) {
                            
                            switch ($category) {
                                case 1:
                                    $dos = 'webdesign';
                                    break;
                                case 2:
                                    $dos = 'graphisme';
                                    break;
                                case 3:
                                    $dos = 'developpement';
                                    break;
                            }

                            $path = "./assets/img/articles/".$dos.'/'.$photoName;
                            
                            $resultat = move_uploaded_file($_FILES["imgs"]["tmp_name"][$i], $path);

                            if ($resultat) {
                                
                                if (($this->_req = $this->getDB()->prepare('INSERT INTO `img_post`
                                                                            (`img_pst_fk`,
                                                                            `img_pst_photo`)
                                                                            VALUES(?, ?)')) !== false) {

                                    $this->_req->execute([$idNewPost, $photoName]);
                                }

                            } else {
                                $msg = 'Une erreur est survenue lors du chargement de vos photos';
                                return $msg;
                            }
                        } else {
                            $msg = 'Vos photos ne sont pas au bon format';
                            return $msg;
                        }
                    }
                    return $idNewPost;
                } else {
                    $msg = "Une erreur est survenue lors de la création de l'article";
                }
           
                    return $msg;
                }

            try {
               
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

         //----------------------------------------------------------------------------
        //--------------------------METHODE ALL ARTICLES BY USER-----------------------
        //-----------------------------------------------------------------------------
        public function readAllArticlesByUser($idUser, $depart, $nbArticlesByPage){
            
            try {
                if (($this->_req = $this->getDb()->prepare("SELECT 
                                                           `pst_id` AS `id`,
                                                           `pst_title` AS `title`,
                                                           `pst_text` AS `text`,
                                                           `pst_date` AS `date`,
                                                           `pst_usr_fk` AS `user`,
                                                           `pst_category_fk` AS `category`
                                                            FROM `post`
                                                            WHERE `pst_usr_fk` = ?
                                                            ORDER BY `pst_date` DESC LIMIT $depart, $nbArticlesByPage")) !== false) {
                    
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
        //------------------------METHODE READ ALL PHOTOS-----------------------------
        //----------------------------------------------------------------------------
        public function updateArticle($title, $text, $category, $id, $oldCategory, $newCategory, $photos){
            
            if (($this->_req = $this->getDb()->prepare('UPDATE `post` 
                                                           SET `pst_title` = ?,
                                                           `pst_text` = ?,
                                                           `pst_date` = NOW(),
                                                           `pst_category_fk` = ?
                                                           WHERE `pst_id` = ?')) !== false ) {

               if (($this->_req->execute([$title, $text, $category, $id])) !== false) {
                   
                    if (!empty($photos)) {

                        foreach ($photos as $photo) {

                            if ($oldCategory->getId() != $newCategory->getId()) {
                        
                                $scrFile = "./assets/img/articles/".$oldCategory->getName().'/'.$photo->getPhotoname();
                                $newSrc = "./assets/img/articles/".$newCategory->getName().'/'.$photo->getPhotoname();
                                rename($scrFile, $newSrc);
                            }
                        }
                    }

                   // Je compte le nombre d'images uploadés
                   $nbPhotos = count($_FILES['imgs']['name']);
                   
                   if (!empty($_FILES['imgs']["name"][0])) {

                   // Pour chaque photo
                   for ($i=0; $i < $nbPhotos; $i++) { 
                       
                       $maxSize = 2097152;
                       // j'initialise son nom
                       $photoName = $_FILES['imgs']['name'][$i];
                       // Je crée un tableau d'extensions valides
                       $validExtensions = ['.png', '.jpg', '.jpeg', '.jpeg'];
                       // Je converti l'extension en minuscule
                       $extension = strtolower(strrchr($photoName, '.'));

                       if (in_array($extension, $validExtensions)) {
                           
                           switch ($category) {
                               case 1:
                                   $dos = 'webdesign';
                                   break;
                               case 2:
                                   $dos = 'graphisme';
                                   break;
                               case 3:
                                   $dos = 'developpement';
                                   break;
                           }

                           $path = "./assets/img/articles/".$dos.'/'.$photoName;
                           
                           $resultat = move_uploaded_file($_FILES["imgs"]["tmp_name"][$i], $path);

                           if ($resultat) {
                               
                               if (($this->_req = $this->getDB()->prepare('INSERT INTO `img_post`
                                                                           (`img_pst_fk`,
                                                                           `img_pst_photo`)
                                                                           VALUES(?, ?)')) !== false) {

                                   $this->_req->execute([$id, $photoName]);
                               }

                           } else {
                               $msg = 'Une erreur est survenue lors du chargement de vos photos';
                               return $msg;
                           }
                       } else {
                           $msg = 'Vos photos ne sont pas au bon format';
                           return $msg;
                       }
                   }
                }
                   $msg = 'Votre article a bien été modifié';
               }
          
                   return $msg;
               }

           try {
              
           } catch(PDOException $e) {

               die($e->getMessage());
           }
       }
        
        //----------------------------------------------------------------------------
        //--------------------------------DELETE ARTICLE------------------------------
        //-----------------------------------------------------------------------------
        public function deleteArticle($idArticle, $photos, $category, $comments){
            
            try {

                if (!empty($photos)) {

                    foreach ($photos as $photo) {

                        $file = "./assets/img/articles/".$category->getName().'/'.$photo->getPhotoname();
                        unlink($file);
                    }

                    if (($this->_req = $this->getDb()->prepare('DELETE  
                                                            FROM `img_post`
                                                            WHERE `img_pst_fk` = ?')) !== false) {
                    
                        $this->_req->execute([$idArticle]);

                     } 
                }

                if (!empty($comments)) {

                    if (($this->_req = $this->getDb()->prepare('DELETE  
                                                            FROM `comment`
                                                            WHERE `com_pst_fk` = ?')) !== false) {
                    
                        $this->_req->execute([$idArticle]);

                     } 
                }

                if (($this->_req = $this->getDb()->prepare('DELETE  
                                                            FROM `post`
                                                            WHERE `pst_id` = ?')) !== false){

                    if (($this->_req->execute([$idArticle])) !== false) {

                        $msg = 'Votre article a bien été supprimé';
                        return $msg;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //------------------METHODE READ ALL ARTICLES BY RESEARCH---------------------
        //----------------------------------------------------------------------------

        // Fonction readAll qui permettra de sélectionner tous les utilisateurs de ma table user dans ma BDD
        public function readAllArticlesByResearch($idCategory, $research, $depart, $articlesByPage) : array{

            try {
                //ici je fais ma requête qui permettra de sélectionner tous les utilisateurs (je cible l'objet en cours également) et je fais un JOIN pour récupérer le libellé su role pour chaque user
                if (($this->_req = $this->getDb()->query("SELECT 
                                                         `pst_id` AS `id`,
                                                         `pst_title` AS `title`,
                                                         `pst_text` AS `text`,
                                                         `pst_date` AS `date`,
                                                         `pst_usr_fk` AS `user`,
                                                         `pst_category_fk` AS `category`
                                                         FROM `post`
                                                         WHERE CONCAT(pst_title, pst_text) LIKE '%".$research."%'
                                                         AND `pst_category_fk` = $idCategory
                                                         ORDER BY `pst_date` DESC LIMIT $depart, $articlesByPage")) !== false) {
                    
                    // J'exécute ma requête
                    if (($this->_req->execute()) !== false) {

                        // Je stocke le résultat de fetchAll sur ma requête dans une variable $datas, qui sera donc un tableau vu que fetchAll me renvoit un tableau avec les tableaux associatifs contenant tous mes users et leurs infos
                        $datas = $this->_req->fetchAll(PDO::FETCH_ASSOC);

                        // Je parcours donc mon tableau $datas qui contient tous mes users
                        
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