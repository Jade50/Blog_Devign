<?php

    // Le fichier appelé Model, correspond à l'interaction avec la BDD
    require_once('Models/CoreModel.php');
    class UserModel extends CoreModel {

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
        //------------------------METHODE SECURISATION $_POST-------------------------
        //----------------------------------------------------------------------------

        public function securisation($donnees){
            $donnees = trim($donnees);
            $donnees = stripslashes($donnees);
            $donnees = strip_tags($donnees);
            $donnees = htmlspecialchars($donnees);
            return $donnees;
        }

        //----------------------------------------------------------------------------
        //--------------------------METHODE READ ALL USERS----------------------------
        //----------------------------------------------------------------------------

        // Fonction readAll qui permettra de sélectionner tous les utilisateurs de ma table user dans ma BDD
        public function readAllUsers() : array{

            try {
                //ici je fais ma requête qui permettra de sélectionner tous les utilisateurs (je cible l'objet en cours également) et je fais un JOIN pour récupérer le libellé su role pour chaque user
                if (($this->_req = $this->getDb()->query('SELECT 
                                                         `usr_id` AS `id`,
                                                         `usr_inscription` AS `inscription`,  
                                                         `usr_name` AS `name`, 
                                                         `usr_first_name` AS `firstname`,
                                                         `usr_about` AS `about`, 
                                                         `usr_email` AS `mail`, 
                                                         `usr_rol_fk` AS `roleId`,
                                                         `usr_avatar` AS `avatar`,
                                                         `rol_name` AS `roleName`
                                                         FROM `user`
                                                         JOIN `role` 
                                                         ON `user`.`usr_rol_fk` = `role`.`rol_id`
                                                         ORDER BY `usr_name`')) !== false) {
                    
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


        //----------------------------------------------------------------------------
        //--------------------------METHODE READ ONE USER-----------------------------
        //----------------------------------------------------------------------------

        public function readOne($id){

            try {
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                            `usr_id` AS `id`, 
                                                            `usr_inscription` AS `inscription`, 
                                                            `usr_name` AS `name`, 
                                                            `usr_first_name` AS `firstName`,
                                                            `usr_email` AS `mail`,
                                                            `usr_about` AS `about`,
                                                            `usr_rol_fk` AS `roleId`,
                                                            `usr_avatar` AS `avatar`,
                                                            `rol_name` AS `roleName`
                                                            FROM `user` 
                                                            JOIN `role` ON `user`.`usr_rol_fk` = `role`.`rol_id`
                                                            WHERE `usr_id` = ?')) !== false) {
                    
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
        //---------------------------METHODE CONNEXION USER---------------------------
        //----------------------------------------------------------------------------

        // Fonction qui récupère en paramètres le mail et le mot de passe de l'utilisateur, via les $_POST remplis sur la page de connexion
        public function connectUser(string $mail, string $pwd){

            // Je sécurise ces données avec ma méthode securisation() créée plus haut
            $mail = $this->securisation($mail);
            $pwd = $this->securisation($pwd);

            try {
                
                // ici je cible ma propriété $_req et je lui stock l'bojet en cours en récupérant ma connexion à la BDD hérité de la class CoreModel, puis je fais une req préparée en renommant grace au AS mes champs de bdd
                if (($this->_req = $this->getDb()->prepare('SELECT 
                                                            `usr_id` AS `id`,
                                                            `usr_email` AS `mail`,
                                                            `usr_password`
                                                            FROM `user`
                                                            WHERE `usr_email` = ?')) !== false) {
                    
                    // Puis je passe mes variables $_POST récupérées en paramètre
                    if (($this->_req->execute([$mail])) !== false) {
                        
                        $user = $this->_req->fetch(PDO::FETCH_ASSOC);
                        // return var_dump($passHash);

                        if (password_verify($pwd, $user['usr_password']) !== false){

                            // ensuite je stocke dans une variable $user le nombre de résultats trouvés en BDD
                            $userExist = $this->_req->rowCount();

                            // Et si un utilisateur avec le mail et mot de passe a été trouvé en BDD
                            if ($userExist == 1) {
                                
                                // Alors je vais chercher les informations de ma requête et les stocke dans ma variable $user
                                return $user['id'];
                            } else {
                                $msg = 'Mauvais identifiants';
                            }
                        } else {
                            $msg = 'Mauvais identifiants';
                        }
                    } else {
                        $msg = 'Une erreur est survenue lors de la connexion, veuillez réessayer';
                    }
                    return $msg;
                }

            } catch (PDOException $e) {
                
                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //-------------------------METHODE INSCRIPTION USER---------------------------
        //----------------------------------------------------------------------------

        // On passe en paramètres tous les champs du formulaire d'inscription
        public function addUser($name, $firstName, $mail, $mailConfirm, $pwd, $pwdConfirm){

            // On les sécurise
            $name = $this->securisation($name);
            $firstName = $this->securisation($firstName);
            $mail = $this->securisation($mail);
            $mailConfirm = $this->securisation($mailConfirm);
            $pwd = $this->securisation($pwd);
            $pwdConfirm = $this->securisation($pwdConfirm);

            try {
                
                // On prépare à insérer les données dans la table user (on passe la valeur 3 au champs `usr_grp_fk` car ce sont seulement les membres et non les admin, qui pourront s'inscrire de cette manière)
                if (($this->_req = $this->getDb()->prepare('INSERT INTO `user` 
                                                            (`usr_inscription`,
                                                            `usr_name`, 
                                                            `usr_first_name`, 
                                                            `usr_email`, 
                                                            `usr_password`, 
                                                            `usr_rol_fk`,
                                                            `usr_avatar`) 
                                                            VALUES (NOW(), ?, ?, ?, ?, 3, ?)')) !== false ) {

                    // On vérifie que le mail soit correct
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                        // On vérifie que les deux mails correspondent
                        if ($mail == $mailConfirm) {

                            // On vérifie que les deux mots de passe correspondent
                            if ($pwd == $pwdConfirm) {

                                    if (preg_match('#[a-zA-Z0-9]{8,}#', $pwd)) {

                                    // On hash le mot de passe afin qu'il soit crypté dans la BDD
                                    $pwd = password_hash($pwd, PASSWORD_DEFAULT);

                                    $avatar = 'profile.jpg';
                                                    
                                    // On exécute la requête en passant les champs du formulaire dans la méthode execute()
                                    if (($this->_req->execute([$name, $firstName, $mail, $pwd, $avatar])) !== false) {
                                        
                                        // Puis on retourne le dernier id entré en BDD pour récupérer l'id du user qui vient de s'inscrire
                                        return $this->lastId();
                                    }
                                } else { 
                                    $msg = 'Votre mot de passe doit contenir au moins 8 caractères et doit être composé de lettres en minuscules et majuscules, ainsi que de chiffres';
                                }
                            } else {
                                $msg = 'Vos mots de passe ne correspondent pas';
                            }
                        } else {
                            $msg = 'Vos adresses mails ne correspondent pas';
                        }
                    } else {
                        $msg = 'Adresse mail invalide';
                    }
                    return $msg;
                }

            } catch (PDOException $e) {
                
                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //-------------------------METHODE LAST INSERT ID-----------------------------
        //----------------------------------------------------------------------------

        public function lastId() {

            // Renvoit le dernier id inséré en BDD 
            return $this->getDb()->lastInsertId();
        }

        //----------------------------------------------------------------------------
        //---------------------------UPDATE GROUP USER--------------------------------
        //----------------------------------------------------------------------------
        public function updateGroup($idUser, $postNewGroup){

            try {
                
                if (($this->_req = $this->getDb()->prepare('UPDATE `user`
                                                            SET `usr_grp_fk` = ?
                                                            WHERE `usr_id` = ?')) !== false) {
                    
                    if (($this->_req->execute([$postNewGroup, $idUser])) !== false) {
                        
                        $msg = 'Groupe de l\'utilisateur modifié';
                        return $msg;
                    }
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //-----------------------------ADD DESC USER----------------------------------
        //----------------------------------------------------------------------------
        public function addDesc($idUser, $desc){
        
            try {
                
                if (($this->_req = $this->getDb()->prepare('UPDATE `user`
                                                            SET `usr_about` = ?
                                                            WHERE `usr_id` = ?')) !== false) {
                    
                    if (($this->_req->execute([$desc, $idUser])) !== false) {
                        
                        $msg = 'Description ajoutée !';
                        return $msg;
                    }
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

         //----------------------------------------------------------------------------
        //-----------------------------NB USERS----------------------------------
        //----------------------------------------------------------------------------
        public function nbUsers(){
        
            try {
                
                if (($this->_req = $this->getDb()->query('SELECT `usr_id` 
                                                          FROM `user`')) !== false) {
                    
                    if (($this->_req->execute()) !== false) {
                        
                        if (($datas = $this->_req->fetchAll(PDO::FETCH_ASSOC))) {
                            
                            $nbUsers = $this->_req->rowcount();   
                            return $nbUsers;
                        }
                    }
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //----------------------------METHODE UPDATE PROFIL---------------------------
        //----------------------------------------------------------------------------

        // On passe en paramètres tous les champs du formulaire d'inscription
        public function updateProfile($idUser, $name, $firstName, $mail, $mailConfirm, $pwd, $pwdConfirm, $desc){

            $name = $this->securisation($name);
            try {

                if (($this->_req = $this->getDb()->prepare('UPDATE `user`
                                                            SET 
                                                            `usr_name` = ?,
                                                            `usr_first_name` = ?,
                                                            `usr_email` = ?,
                                                            `usr_about` = ?
                                                            WHERE `usr_id` = ?')) !== false ) {

                    // On vérifie que le mail soit corretc
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                        // On vérifie que les deux mails correspondent
                        if ($mail == $mailConfirm) {
                                                
                                // On exécute la requête en passant les champs du formulaire dans la méthode execute()
                                if (($this->_req->execute([$name, $firstName, $mail, $desc, $idUser])) !== false) {
                                    
                                    $msg = 'Votre profil a bien été modifié';

                                    if (!empty($pwd) && !empty($pwdConfirm)) {
                                        
                                        if ($pwd == $pwdConfirm) {

                                            // On hash le mot de passe afin qu'il soit crypté dans la BDD
                                            $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                                                            
                                           if (($this->_req = $this->getDb()->prepare('UPDATE `user`
                                                                                                                                    SET `usr_password` = ?
                                                                                                                                    WHERE `usr_id` = ?')) !== false) {
                                               
                                               if (($this->_req->execute([$pwd, $idUser])) !== false) {
                                                   
                                                    $msg = 'Votre profil a bien été modifié';
                                                    return $msg;
                                               }
                                           }

                                        } else {
                                            $msg = 'Vos mots de passe ne correspondent pas';
                                        }

                                    } else {
                                        $msg = 'Votre profil a bien été modifié';
                                    }
                                }

                        } else {
                            $msg = 'Vos adresses mails ne correspondent pas';
                        }
                    } else {
                        $msg = 'Adresse mail non valide';
                    }
                    return $msg;
                }

            } catch (PDOException $e) {
                
                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //--------------------------METHODE DELETE USER-------------------------------
        //----------------------------------------------------------------------------
        public function deleteUser($idUser){
            
            try {
                if (($this->_req = $this->getDb()->prepare('DELETE 
                                                            FROM `user`
                                                            WHERE `usr_id` = ?')) !== false) {
                    
                    if (($this->_req->execute([$idUser])) !== false) {

                        $msg = 'Cet utilisateur a bien été supprimé';

                        return $msg;
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //-----------------------------CHANGE AVATAR----------------------------------
        //----------------------------------------------------------------------------
        public function updateAvatar($idUser){
            
            try {

                if (!empty($_FILES['avatar']['name'])) {

                    $photoName = $_FILES['avatar']['name'];

                    $validExtensions = ['.png', '.jpg', '.jpeg', '.jpeg'];
                    // Je converti l'extension en minuscule
                    $extension = strtolower(strrchr($photoName, '.'));

                    if (in_array($extension, $validExtensions)) {

                        $path = "./assets/img/avatars/".$photoName;
                           
                        $resultat = move_uploaded_file($_FILES["avatar"]["tmp_name"], $path);

                        if ($resultat) {

                            if (($this->_req = $this->getDb()->prepare('UPDATE `user`
                                                                        SET `usr_avatar` = ?
                                                                        WHERE `usr_id` = ?')) !== false) {

                                if (($this->_req->execute([$photoName, $idUser])) !== false) {

                                    $msg = 'L\'avatar a bien été modifié';

                                    return $msg;
                                }
                            }
                        }
                    }
                }
                return false;
            } catch(PDOException $e) {

                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //--------------------------METHODE READ ALL ROLES----------------------------
        //----------------------------------------------------------------------------

        // Fonction readAll qui permettra de sélectionner tous les utilisateurs de ma table user dans ma BDD
        public function readAllRoles() : array{

            try {
                //ici je fais ma requête qui permettra de sélectionner tous les utilisateurs (je cible l'objet en cours également) et je fais un JOIN pour récupérer le libellé su role pour chaque user
                if (($this->_req = $this->getDb()->query('SELECT 
                                                         `rol_id` AS `id`,
                                                         `rol_name` AS `name`  
                                                         FROM `role`
                                                         ORDER BY `rol_id`')) !== false) {
                    
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

        //----------------------------------------------------------------------------
        //-----------------------------METHODE UPDATE USER----------------------------
        //----------------------------------------------------------------------------

        // On passe en paramètres tous les champs du formulaire d'inscription
        public function updateUser($idUser, $name, $firstName, $mail, $mailConfirm, $role, $pwd, $pwdConfirm, $desc){

            try {

                if (($this->_req = $this->getDb()->prepare('UPDATE `user`
                                                            SET 
                                                            `usr_name` = ?,
                                                            `usr_first_name` = ?,
                                                            `usr_email` = ?,
                                                            `usr_rol_fk` = ?,
                                                            `usr_about` = ?
                                                            WHERE `usr_id` = ?')) !== false ) {

                    // On vérifie que le mail soit corretc
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                        // On vérifie que les deux mails correspondent
                        if ($mail == $mailConfirm) {
                                                
                                // On exécute la requête en passant les champs du formulaire dans la méthode execute()
                                if (($this->_req->execute([$name, $firstName, $mail, $role, $desc, $idUser])) !== false) {
                                    
                                    $msg = 'Le profil a bien été modifié';

                                    if (!empty($pwd) && !empty($pwdConfirm)) {
                                        
                                        if ($pwd == $pwdConfirm) {

                                            // On hash le mot de passe afin qu'il soit crypté dans la BDD
                                            $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                                                            
                                           if (($this->_req = $this->getDb()->prepare('UPDATE `user`
                                                                                       SET `usr_pwd` = ?WHERE `usr_id` = ?')) !== false) {
                                               
                                               if (($this->_req->execute([$pwd, $idUser])) !== false) {
                                                   
                                                    $msg = 'Le profil a bien été modifié';
                                                    return $msg;
                                               }
                                           }

                                        } else {
                                            $msg = 'Les mots de passe ne correspondent pas';
                                        }

                                    } else {
                                        $msg = 'Le profil a bien été modifié';
                                    }
                                }

                        } else {
                            $msg = 'Les adresses mails ne correspondent pas';
                        }
                    } else {
                        $msg = 'Adresse mail non valide';
                    }
                    return $msg;
                }

            } catch (PDOException $e) {
                
                die($e->getMessage());
            }
        }

        //----------------------------------------------------------------------------
        //--------------------METHODE READ ALL USERS BU RESEARCH----------------------
        //----------------------------------------------------------------------------

        // Fonction readAll qui permettra de sélectionner tous les utilisateurs de ma table user dans ma BDD
        public function readAllUsersByResearch($research) : array{

            try {
                //ici je fais ma requête qui permettra de sélectionner tous les utilisateurs (je cible l'objet en cours également) et je fais un JOIN pour récupérer le libellé su role pour chaque user
                if (($this->_req = $this->getDb()->query("SELECT 
                                                         `usr_id` AS `id`,
                                                         `usr_inscription` AS `inscription`,  
                                                         `usr_name` AS `name`, 
                                                         `usr_first_name` AS `firstname`,
                                                         `usr_about` AS `about`, 
                                                         `usr_email` AS `mail`, 
                                                         `usr_rol_fk` AS `roleId`,
                                                         `usr_avatar` AS `avatar`,
                                                         `rol_name` AS `roleName`
                                                         FROM `user`
                                                         JOIN `role` 
                                                         ON `user`.`usr_rol_fk` = `role`.`rol_id`
                                                         WHERE CONCAT(usr_name, usr_first_name) LIKE '%".$research."%'")) !== false) {
                    
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