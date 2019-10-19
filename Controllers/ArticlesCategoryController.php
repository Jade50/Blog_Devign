<?php

    class ArticlesCategoryController {

        private $_model;

        // à chaque instanciation du controller, il instanciera le model
        public function __construct(){

            try {
                
                $this->_model = new ArticleModel;

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //----------------------------------INDEX-------------------------------------
        //----------------------------------------------------------------------------

        public function index(){

            try {

                 // Articles Catégorie 
                 $datasCategoriesArticles = $this->_model->readAllCategories();

                 $articlesCategories =[];
 
                 if (count($datasCategoriesArticles) > 0) {
 
                     foreach ($datasCategoriesArticles as $data) {
 
                         $articlesCategories[] = new ArticleCategory($data);
                     }
                 }

                 if (!empty($articlesCategories)) {
                    foreach ($articlesCategories as $category) {
                        $nbArticles = $this->_model->nbArticles($category->getId());
                        $category->setNbArticles($nbArticles);
                    }
                }

                // Derniers articles postés
                 $lastArticles= [];
          
                 if (!empty($articlesCategories)) {
                     foreach ($articlesCategories as $category) {
                         $data = $this->_model->readLastArticle($category->getId());
                         if (!empty($data)) {
                             $lastArticles[] = new Article($data);
                         }
                     }
                 }

                 // Dernières photos par articles
                 if (!empty($lastArticles)) {
                     foreach ($lastArticles as $lastArticle) {
                         $lastPhoto = $this->_model->readLastImg($lastArticle->getId());
                         if (!empty($lastPhoto)) {
                             $lastArticle->setLastImg($lastPhoto['photoname']);
                         }
                     }
                 }


            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/articles_categories.php');
        }

        //----------------------------------------------------------------------------
        //-------------------------ALL ARTICLES BY CATEGORY---------------------------
        //----------------------------------------------------------------------------

        public function articlesByCategory($idCategory){

            try {

                 // Articles Catégorie 
                 $dataCategory = $this->_model->readCategory($idCategory);

                 if (count($dataCategory) > 0) {
 
                    $category = new ArticleCategory($dataCategory);   
                 }

                 // Nb Articles 
                 $nbArticles = $this->_model->nbArticles($idCategory);
                 $category->setNbarticles($nbArticles);



                //PAGINATION-------------------------------
                // On définit le nombre d'articles par  pages
                $nbArticlesByPage = 8;
                // on divise le nombre total d'articles par le nombre d'articles par page
                $totalPages = ceil($category->getNbarticles() / $nbArticlesByPage);

                // on défini la page dans l'url
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
              
                // On déduit à partir de quel article on veut afficher, donc on récupère la page en cours en enlevant 1, par exemple 2 - 1 = 1, * le nombre d'articles par page et on obtient 1 * 8 donc 8. Don on commencera l'affichage à partir de 8
                $depart = ($currentPage-1)*$nbArticlesByPage;
                //-----------------------------------

                 // Tous les articles
                 $datasArticles = $this->_model->readAllArticlesByCategory($idCategory, $depart, $nbArticlesByPage);

                 $articles = [];

                 if (!empty($datasArticles)) {
                     foreach ($datasArticles as $data) {
                        $articles[] = new Article($data);
                     }
                 }

                 $commentModel = new CommentModel();
                 $userModel = new UserModel();

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

                        $user = $userModel->readOne($article->getUser());
                        $userDatas = new User($user);
                        $article->setUser($userDatas);
                    }
                }

               
            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/articles_by_category.php');
        }


        //----------------------------------------------------------------------------
        //-------------------------ALL ARTICLES BY CATEGORY---------------------------
        //----------------------------------------------------------------------------

        public function showArticle($idArticle){

            try {

                // Article
                $dataArticle = $this->_model->readOneArticle($idArticle);

                $commentModel = new CommentModel();
                $userModel = new UserModel();

                if (count($dataArticle) > 0) {

                   $article = new Article($dataArticle);   
                   $user = $userModel->readOne($article->getUser());
                   $userDatas = new User($user);
                   $article->setUser($userDatas);
                }

                $dataCategory = $this->_model->readCategory($article->getCategory());

                if (count($dataCategory) > 0) {

                   $category = new ArticleCategory($dataCategory);   
                }

                // Photos
                 $datasImg = $this->_model->readAllImg($article->getId());

                 $photos = [];

                 if (!empty($datasImg)) {
                     foreach ($datasImg as $data) {
                        $photos[] = new PhotoArticle($data);
                     }
                 }

                // Commentaires
                $datasComments = $commentModel->readAllComments($article->getId());

                $comments = [];

                if (!empty($datasComments)) {
                    foreach ($datasComments as $data) {
                       $comments[] = new Comment($data);
                    }
                }

                if (!empty($comments)) {
                    foreach ($comments as $comment) {
                        $user = $userModel->readOne($comment->getUser());
                        $userDatas = new User($user);
                        $comment->setUser($userDatas);
                    }
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/article.php');
        }


        //----------------------------------------------------------------------------
        //---------------------------------ADD COMMENT--------------------------------
        //----------------------------------------------------------------------------

        public function newComment($post){

            try {

                if (!empty($post['comment']) && !empty($post['user']) && !empty($post['article'])) {
                    
                    $commentModel = new CommentModel;

                    $msg = $commentModel->addComment($post['comment'], $post['article'], $post['user']);

                    header('Location:/Devign_2/ArticlesCategory/showArticle/'.$post['article'].'/'.$msg);

                    exit();

                } else {
                    
                    $msg = 'Veuillez remplir tous les champs';

                    header('Location:/Devign_2/ArticlesCategory/showArticle/'.$post['article'].'/'.$msg);

                    exit();
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/article.php');
        }

        //----------------------------------------------------------------------------
        //-------------------------ALL ARTICLES BY CATEGORY---------------------------
        //----------------------------------------------------------------------------

        public function articlesByResearchAndByCategory($post){

            try {

                if (!empty($post['research']) && !empty($post['category'])) {
                    // Articles Catégorie 
                    $dataCategory = $this->_model->readCategory($post['category']);

                    if (count($dataCategory) > 0) {
    
                        $category = new ArticleCategory($dataCategory);   
                    }

                    //nb Articles 
                    $nbArticles = $this->_model->nbArticles($category->getId());
                    $category->setNbarticles($nbArticles);

                    // PAGINATION
                    $nbArticlesByPage = 8;
                    $totalPages = ceil($category->getNbarticles() / $nbArticlesByPage);
    
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
                    $datasArticles = $this->_model->readAllArticlesByResearch($post['category'], $post['research'], $depart, $nbArticlesByPage);

                    $articles = [];

                    if (!empty($datasArticles)) {
                        foreach ($datasArticles as $data) {
                            $articles[] = new Article($data);
                        }
                    }

                    $commentModel = new CommentModel();
                    $userModel = new UserModel();

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

                            $user = $userModel->readOne($article->getUser());
                            $userDatas = new User($user);
                            $article->setUser($userDatas);
                        }
                    }
                    
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/articles_by_category.php');
        }
    }
