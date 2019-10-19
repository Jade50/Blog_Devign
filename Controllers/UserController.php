<?php

    class UserController  {

        private $_model;

        // à chaque instanciation du controller, il instanciera le model
        public function __construct(){

            try {
                
                $this->_model = new UserModel;


            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //--------------------------------SECURISATION--------------------------------
        //----------------------------------------------------------------------------
        public function securisation($donnees){
            $donnees = trim($donnees);
            $donnees = stripslashes($donnees);
            $donnees = strip_tags($donnees);
            $donnees = htmlspecialchars($donnees);
            return $donnees;
        }

        //----------------------------------------------------------------------------
        //----------------------------------CONNEXION---------------------------------
        //----------------------------------------------------------------------------

        public function connexion(){

            include('./Views/connexion.php');
        }

        //----------------------------------------------------------------------------
        //----------------------------------CONNEXION---------------------------------
        //----------------------------------------------------------------------------

        public function connectUser($post){
            
            if (!empty($post['email']) && !empty($post['password'])) {

                $mail = $this->securisation($post['email']);
                $password = $this->securisation($post['password']);

                $userExists = $this->_model->connectUser($mail, $password);

                if (ctype_digit($userExists)) {

                    $idUser = $userExists;
    
                    $user = $this->_model->readOne($idUser);
    
                    $user = new User($user);

                    $_SESSION['devign']['userId'] = $user->getId();

                    header('Location:/Devign_2/User/myProfile/'.$_SESSION['devign']['userId']);
                    exit();
    
                } else {

                    $msg = $userExists;
                }

            } else {
                $msg = 'Veuillez remplir tous les champs';
            }
            header('Location:/Devign_2/User/connexion/'.$msg);
            exit();
        }


        //----------------------------------------------------------------------------
        //-------------------------------INSCRIPTION----------------------------------
        //----------------------------------------------------------------------------
        public function subscribe(){

            include('./Views/inscription.php');
        }

        //----------------------------------------------------------------------------
        //---------------------------------NEW USER-----------------------------------
        //----------------------------------------------------------------------------
        public function subscribeUser($post){

            try {

                if (!empty($post['name']) && !empty($post['first-name']) && !empty($post['email']) && !empty($post['email-confirm']) && !empty($post['password']) && !empty($post['password-confirm'])) {

                    $name = $this->securisation($post['name']);
                    $firstName = $this->securisation($post['first-name']);
                    $email = $this->securisation($post['email']);
                    $emailConfirm = $this->securisation($post['email-confirm']);
                    $password = $this->securisation($post['password']);
                    $passwordConfirm = $this->securisation($post['password-confirm']);

                    $newUser = $this->_model->addUser($name, $firstName, $email, $emailConfirm, $password, $passwordConfirm);

                    if (ctype_digit($newUser)) {
                        
                        // Je renomme donc cet id
                        $idUser = $newUser;
        
                        // et avec la méthode read() en passant l'id du user en paramètres je récupère un tableau avec toutes ses données 
                        $user = $this->_model->readOne($idUser);
        
                        // Puis je crée un objet $user en passant au constructeur le tableau qui contient toutes les infos de mon user
                        $user = new User($user);

                        // Puis je stocke dans une session l'id de cet utilisateur
                        $_SESSION['devign']['userId'] = $user->getId();

                        header('Location:/Devign_2/User/myProfile/'.$_SESSION['devign']['userId']);
                        exit();
                    } else {
                        // Sinon, si le résultat de la méthode connectUser ne renvoi pas d'id c'est qu'elle a retourné un message d'erreur, donc je le stocke dans une variable $msg, pour que ce message soit affiché sur ma page
                        $msg = $newUser;
                    }
                }else {
                    $msg = 'Veuillez remplir tous les champs';
                }

                header('Location:/Devign_2/User/subscribe/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //--------------------------------MY PROFILE----------------------------------
        //----------------------------------------------------------------------------
        public function myProfile($id){

            try {

                $user = $this->_model->readOne($id);
        
                // Puis je crée un objet $user en passant au constructeur le tableau qui contient toutes les infos de mon user
                $user = new User($user);

                $articleModel = new ArticleModel();
                $forumModel = new ForumModel();
                $conversationModel = new ConversationModel();

                if ($user->getRoleId() == 1 || $user->getRoleId() == 2) {
                    $nbArticles = $articleModel->nbArticlesByUser($user->getId());
                    $nbUsers = $this->_model->nbUsers($user->getId());
                }

                $nbTopics = $forumModel->nbTopicsByUser($user->getId());
                $nbConversations = $conversationModel->nbConversationsByUser($user->getId());

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
            // $this->view('myprofile');
            include('./Views/myprofile.php');
        }

         //----------------------------------------------------------------------------
        //--------------------------------MY PROFILE----------------------------------
        //----------------------------------------------------------------------------
        public function Profile($idUser){

            try {

                $user = $this->_model->readOne($idUser);
        
                // Puis je crée un objet $user en passant au constructeur le tableau qui contient toutes les infos de mon user
                $user = new User($user);

                $articleModel = new ArticleModel();
                $forumModel = new ForumModel();

                if ($user->getRoleId() == 1 || $user->getRoleId() == 2) {
                    $nbArticles = $articleModel->nbArticlesByUser($user->getId());
                    $nbUsers = $this->_model->nbUsers($user->getId());
                }

                $nbTopics = $forumModel->nbTopicsByUser($user->getId());

                // CONV EXISTS
                if (isset($_SESSION['devign']['userId'], $idUser)) {
                    $conversationModel = new ConversationModel;
                    $conv = $conversationModel->searchConversation($_SESSION['devign']['userId'], $idUser);
                }


            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
            
            include('./Views/profile.php');
        }

        //----------------------------------------------------------------------------
        //----------------------------DISCONNECTION-----------------------------------
        //----------------------------------------------------------------------------

        public function disconnection(){

            unset($_SESSION['devign']['userId']);
        
            header('Location:/Devign_2/User/Connexion/');
            exit();
        }

        
        //----------------------------------------------------------------------------
        //--------------------------------ALL USERS-----------------------------------
        //----------------------------------------------------------------------------
        public function allUsers($idUser){

            try {

                $user = $this->_model->readOne($idUser);
        
                // Puis je crée un objet $user en passant au constructeur le tableau qui contient toutes les infos de mon user
                $user = new User($user);

                $datasUsers = $this->_model->readAllUsers();

                $usersView = [];

                if (!empty($datasUsers)) {
                    foreach ($datasUsers as $data) {
                    $usersView[] = new User($data);
                    }
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/all_users.php');
        }

        //----------------------------------------------------------------------------
        //------------------------------DELETE USER-----------------------------------
        //----------------------------------------------------------------------------
        public function deleteUser($idUser){

            try {

                $msg = $this->_model->deleteUser($idUser);
                
                header('Location:/Devign_2/User/allUsers/'.$_SESSION['devign']['userId'].'/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/all_users.php');
        }

        //----------------------------------------------------------------------------
        //------------------------------CHANGE AVATAR---------------------------------
        //----------------------------------------------------------------------------
        public function changeAvatar($idUser){

            try {

                $msg = $this->_model->updateAvatar($idUser);
                
                header('Location:/Devign_2/User/updateProfile/'.$_SESSION['devign']['userId'].'/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/all_users.php');
        }

        //----------------------------------------------------------------------------
        //------------------------------UPDATE PROFILE---------------------------------
        //----------------------------------------------------------------------------
        public function updateProfile($idUser){

            try {

                $user = $this->_model->readOne($idUser);
                $user = new User($user);

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/update_profile.php');
        }

        //----------------------------------------------------------------------------
        //---------------------------UPDATE PROFILE TREAT-----------------------------
        //----------------------------------------------------------------------------
        public function updateProfileTreat($post){

            try {

                if (!empty($post['user']) && !empty($post['name']) && !empty($post['first-name']) && !empty($post['mail']) && !empty($post['mail-confirm']) && !empty($post['desc'])) {
                    
                    $msg = $this->_model->updateProfile($post['user'], $post['name'], $post['first-name'], $post['mail'], $post['mail-confirm'], $post['pwd'], $post['pwd-confirm'], $post['desc']);

                    header('Location:/Devign_2/User/updateProfile/'.$_SESSION['devign']['userId'].'/'.$msg);
                    exit();
                } else {

                    $msg = 'Veuillez remplir tous les champs';
                }
                
                header('Location:/Devign_2/User/updateProfile/'.$_SESSION['devign']['userId'].'/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

        }

        //----------------------------------------------------------------------------
        //------------------------------UPDATE PROFILE---------------------------------
        //----------------------------------------------------------------------------
        public function updateUser($idUser){

            try {

                $user = $this->_model->readOne($_SESSION['devign']['userId']);
                $user = new User($user);

                $userView = $this->_model->readOne($idUser);
                $userView = new User($userView);

                $roles = $this->_model->readAllRoles();


            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/update_user.php');
        }

        //----------------------------------------------------------------------------
        //-----------------------------UPDATE USER TREAT------------------------------
        //----------------------------------------------------------------------------
        public function updateUserTreat($post){

            try {

                if (!empty($post['user']) && !empty($post['name']) && !empty($post['first-name']) && !empty($post['mail']) && !empty($post['mail-confirm']) && !empty($post['role']) && !empty($post['desc'])) {
                    
                    $msg = $this->_model->updateUser($post['user'], $post['name'], $post['first-name'], $post['mail'], $post['mail-confirm'], $post['role'], $post['pwd'], $post['pwd-confirm'], $post['desc']);

                    header('Location:/Devign_2/User/updateUser/'.$post['user'].'/'.$msg);
                    exit();
                } else {

                    $msg = 'Veuillez remplir tous les champs';
                }
                
                header('Location:/Devign_2/User/updateUser/'.$post['user'].'/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/update_profile.php');
        }

        //----------------------------------------------------------------------------
        //------------------------------CHANGE AVATAR---------------------------------
        //----------------------------------------------------------------------------
        public function changeAvatarUser($idUser){

            try {

                $msg = $this->_model->updateAvatar($idUser);
                
                header('Location:/Devign_2/User/updateUser/'.$idUser.'/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //------------------------------CHANGE AVATAR---------------------------------
        //----------------------------------------------------------------------------
        public function addDesc($post){

            try {

                if (!empty($post['user']) && $post['desc']) {

                    $msg = $this->_model->addDesc($post['user'], $post['desc']);
                
                    header('Location:/Devign_2/User/myProfile/'.$post['user'].'/'.$msg);
                    exit();
                } else {
                    $msg = 'Veuillez remplir tous les champs';
                }

                header('Location:/Devign_2/User/myProfile/'.$post['user'].'/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //------------------------------CHANGE AVATAR---------------------------------
        //----------------------------------------------------------------------------
        public function allUsersResearch($post){

            try {

                if (!empty($post['research'])) {

                    $user = $this->_model->readOne($_SESSION['devign']['userId']);
            
                    // Puis je crée un objet $user en passant au constructeur le tableau qui contient toutes les infos de mon user
                    $user = new User($user);

                    $datasUsers = $this->_model->readAllUsersByResearch($post['research']);

                    $usersView = [];

                    if (!empty($datasUsers)) {
                        foreach ($datasUsers as $data) {
                        $usersView[] = new User($data);
                        }
                    }

                } else {
                    $msg = 'Veuillez remplir le champ';
                    header('Location:/Devign_2/User/allUsers/'.$_SESSION['devign']['userId'].'/'.$msg);
                    exit();
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
            include('./Views/all_users.php');
        }
        

    }
