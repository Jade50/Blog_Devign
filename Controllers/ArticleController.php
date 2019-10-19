<?php

    class ArticleController {

        private $_model;

        // à chaque instanciation du controller, le model associé
        // sera instancié
        public function __construct(){

            try {
                
                $this->_model = new ArticleModel;

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
        //--------------------------------NEW ARTICLE---------------------------------
        //----------------------------------------------------------------------------

        public function newArticle($idUser){

            try {

                $userModel = new UserModel();
                $user = $userModel->readOne($idUser);
    
                $user = new User($user);

                  // Catégories Articles
                  $datasCategoriesArticles = $this->_model->readAllCategories();

                  $articlesCategories =[];
  
                  if (count($datasCategoriesArticles) > 0) {
  
                      foreach ($datasCategoriesArticles as $data) {
  
                          $articlesCategories[] = new ArticleCategory($data);
                      }
                  }
  

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/add_article.php');
        }

        //----------------------------------------------------------------------------
        //-----------------------------ADD NEW ARTICLE--------------------------------
        //----------------------------------------------------------------------------

        public function addNewArticle($post){

            try {

                if (!empty($post['title']) && !empty($post['category']) && !empty($post['text']) && !empty($post['user'])) {

                    $title = $this->securisation($post['title']);
                    $text = $this->securisation($post['text']);
                    $category = $this->securisation($post['category']);
                    $user = $this->securisation($post['user']);
                    
                    if (!empty($_FILES['imgs']['name'][0])) {

                        $newArticle = $this->_model->addArticle($title, $text, $category, $user);

                        if (ctype_digit($newArticle)) {

                            $idArticle = $newArticle;
                            
                            header('Location:/Devign_2/ArticlesCategory/showArticle/'.$idArticle);
                            exit();

                        } else {
                            $msg = $newArticle;
                        }

                    } else {
                        $msg = 'Veuillez charger une image';
                    }
                    
                 }else {
                    $msg = 'Veuillez remplir tous les champs';
                }

                header('Location:/Devign_2/Article/newArticle/'.$_SESSION['devign']['userId'].'/'.$msg);
                exit();
              
            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

        }

        //----------------------------------------------------------------------------
        //--------------------------------NEW ARTICLE---------------------------------
        //----------------------------------------------------------------------------

        public function validComments($idUser){

            try {

                $userModel = new UserModel();
                $articleModel = new ArticleModel();

                $user = $userModel->readOne($idUser);
    
                $user = new User($user);

                //commentaires à valider
                $commentModel = new CommentModel;

                $datasComments = $commentModel->readCommentsToValidate($idUser);
                $comments =[];

                if (count($datasComments) > 0) {

                    foreach ($datasComments as $data) {

                        $comments[] = new Comment($data);
                    }
                }

                if (!empty($comments)) {
                    foreach ($comments as $comment) {
                        $userComment = $userModel->readOne($comment->getUser());
                        $userComment = new User($userComment);
                        $comment->setUser($userComment);

                        $article = $articleModel->readOneArticle($comment->getArticle());
                        $article = new Article($article);
                        $comment->setArticle($article);
                    }
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/valid_comments.php');
        }

        //----------------------------------------------------------------------------
        //--------------------------------VALID COMMENT-------------------------------
        //----------------------------------------------------------------------------

        public function validComment($idComment){

            try {

                $commentModel = new CommentModel;

                $msg = $commentModel->ValidateComment($idComment);
                header('Location:/Devign_2/Article/ValidComments/'.$_SESSION['devign']['userId'].'/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/valid_comments.php');
        }

        //----------------------------------------------------------------------------
        //--------------------------------VALID COMMENT-------------------------------
        //----------------------------------------------------------------------------

        public function deleteComment($idComment){

            try {

                $commentModel = new CommentModel;

                $msg = $commentModel->deleteComment($idComment);
                
                header('Location:/Devign_2/Article/ValidComments/'.$_SESSION['devign']['userId'].'/'.$msg);
                exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/valid_comments.php');
        }

          //----------------------------------------------------------------------------
        //-------------------------ALL ARTICLES BY CATEGORY---------------------------
        //----------------------------------------------------------------------------

        public function myArticles($idUser){

            try {

                 // Articles Catégorie 
                //  $dataCategory = $this->_model->readCategory($idCategory);

                //  if (count($dataCategory) > 0) {
 
                //     $category = new ArticleCategory($dataCategory);   
                //  }
                $userModel = new userModel;
                $user = $userModel->readOne($idUser);
    
                $user = new User($user);

                
                //nb Articles 
                $nbArticles = $this->_model->nbArticlesByUser($idUser);

                // PAGINATION
                $nbArticlesByPage = 8;
                $totalPages = ceil($nbArticles / $nbArticlesByPage);
    
                if (isset($_GET['url'])) {
                    $url = explode('/', $_GET['url']);
                    if (isset($url[3])) {
                        if ($url[3] > 0) {
                            $currentPage = $url[3];
                        } else {
                             $currentPage = 1;
                         }
                    }
                }
                  
                $depart = ($currentPage-1)*$nbArticlesByPage;


                 // Tous les articles
                 $datasArticles = $this->_model->readAllArticlesByUser($idUser, $depart, $nbArticlesByPage);

                 $articles = [];

                 if (!empty($datasArticles)) {
                     foreach ($datasArticles as $data) {
                        $articles[] = new Article($data);
                     }
                 }

                 $commentModel = new CommentModel();

                 // Dernière photo par article
                 if (!empty($articles)) {
                    foreach ($articles as $article) {
                        $lastPhoto = $this->_model->readLastImg($article->getId());
                        if (!empty($lastPhoto)) {
                            $article->setLastImg($lastPhoto['photoname']);
                        }
                        // nombre de commentaires par articleS
                        $nbComments = $commentModel->nbComments($article->getId());
                        $article->setNbcomments($nbComments);

                        $category = $this->_model->readCategory($article->getCategory());
                        $categoryDatas = new ArticleCategory($category);
                        $article->setCategory($categoryDatas);
                    }
                }

               
            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/my_articles.php');
        }

        //----------------------------------------------------------------------------
        //-------------------------------UPDATE ARTICLE-------------------------------
        //----------------------------------------------------------------------------

        public function updateArticle($idArticle){

            try {

                // user
                $userModel = new userModel;
                $user = $userModel->readOne($_SESSION['devign']['userId']);
                $user = new User($user);

                // article
                $datasArticle = $this->_model->readOneArticle($idArticle);
                $article = new Article($datasArticle);

                $dataCategory = $this->_model->readCategory($article->getCategory());
                $articleCategory = new ArticleCategory($dataCategory);
                $article->setCategory($articleCategory);

                

                // photos
                $datasImg = $this->_model->readAllImg($article->getId());

                $photos = [];

                if (!empty($datasImg)) {
                    foreach ($datasImg as $data) {
                       $photos[] = new PhotoArticle($data);
                    }
                }

                // catégories
                $datasCategoriesArticles = $this->_model->readAllCategories();

                $articlesCategories =[];

                if (count($datasCategoriesArticles) > 0) {

                    foreach ($datasCategoriesArticles as $data) {

                        $articlesCategories[] = new ArticleCategory($data);
                    }
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/update_article.php');
        }

        
        //----------------------------------------------------------------------------
        //-----------------------------UPDATE ARTICLE--------------------------------
        //----------------------------------------------------------------------------

        public function UpdateArticleTreat($post){

            try {

                if (!empty($post['title']) && !empty($post['category']) && !empty($post['text']) && !empty($post['id'])) {
                    
                    $dataArticle = $this->_model->readOneArticle($post['id']);
                    $article = new Article($dataArticle);

                    $dataCategory = $this->_model->readCategory($article->getCategory());
                    $articleCat = new ArticleCategory($dataCategory);
                    $article->setCategory($articleCat);

                    $datasNewCategory = $this->_model->readCategory($post['category']);
                    $newCategory = new ArticleCategory($datasNewCategory);

                    $datasImg = $this->_model->readAllImg($article->getId());

                    $photos = [];
    
                    if (!empty($datasImg)) {
                        foreach ($datasImg as $data) {
                           $photos[] = new PhotoArticle($data);
                        }
                    }

                    $articleModified = $this->_model->updateArticle($post['title'], $post['text'], $post['category'], $post['id'], $article->getCategory(), $newCategory, $photos);

                    $msg = $articleModified;
                            
                    header('Location:/Devign_2/Article/updateArticle/'.$post['id'].'/'.$msg);
                    exit();
                    
                 }else {
                    $msg = 'Veuillez remplir tous les champs';
                }

                header('Location:/Devign_2/User/myProfile/'.$_SESSION['devign']['userId'].'/'.$msg);
                exit();
              
            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

        }

        //----------------------------------------------------------------------------
        //-----------------------------UPDATE ARTICLE--------------------------------
        //----------------------------------------------------------------------------

        public function deleteArticle($idArticle){

            try {

                    $dataArticle = $this->_model->readOneArticle($idArticle);
                    $article = new Article($dataArticle);

                    $commentModel = new CommentModel();
                    $datasComments = $commentModel->readAllComments($idArticle);
                    
                    $comments = [];

                    if (!empty($datasComments)) {
                        foreach ($datasComments as $data) {
                        $comments[] = new Comment($data);
                        }
                    }

                    $dataCategory = $this->_model->readCategory($article->getCategory());
                    $category = new ArticleCategory($dataCategory);

                    $datasImg = $this->_model->readAllImg($idArticle);

                    $photos = [];

                    if (!empty($datasImg)) {
                        foreach ($datasImg as $data) {
                        $photos[] = new PhotoArticle($data);
                        }
                    }

                $msg = $this->_model->deleteArticle($idArticle, $photos, $category, $comments);

                header('Location:/Devign_2/Article/myArticles/'.$_SESSION['devign']['userId'].'/1'.'/'.$msg);
                exit();
              
            }catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }
    }
    
