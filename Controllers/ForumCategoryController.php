<?php

    class ForumCategoryController {

        private $_model;

        // à chaque instanciation du controller, il instanciera le model
        public function __construct(){

            try {
                
                $this->_model = new ForumModel;

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //----------------------------------INDEX-------------------------------------
        //----------------------------------------------------------------------------

        public function index(){

            try {

                $datasCategories = $this->_model->readAllCategories();

                $Categories =[];

                if (count($datasCategories) > 0) {

                    foreach ($datasCategories as $data) {

                        $Categories[] = new ForumCategory($data);
                    }
                }


                $datasSubCat = $this->_model->readAllSubCategories();

                $subCategories =[];

                if (count($datasSubCat) > 0) {

                    foreach ($datasSubCat as $data) {

                        $subCategories[] = new ForumSubCategory($data);
 
                    }
                }

                if (!empty($subCategories)) {
                    foreach ($subCategories as $subCategory) {
                        $nbTopics = $this->_model->nbTopics($subCategory->getId());
                        $subCategory->setNbtopics($nbTopics);
                    }
                }

                $lastTopics = [];
          
                if (!empty($subCategories)) {
                    foreach ($subCategories as $subCategorie) {
                        $data = $this->_model->readLastTopic($subCategorie->getId());
                        if (!empty($data)) {
                            $lastTopics[] = new ForumTopic($data);
                        } else {
                            $test = 'test';
                        }
                    }
                }
    
                if (!empty($lastTopics)) {

                    foreach ($lastTopics as $lastTopic) {

                        foreach ($datasSubCat as $subCat) {

                            if ($lastTopic->getSubcategory() == $subCat['id']) {
                                $lastTopic->setSubcategory(new ForumSubCategory($subCat));
                                
                                foreach ($datasCategories as $category) {
                                    if ($lastTopic->GetSubcategory()->GetCategory() == $category['id']) {
                                        
                                        $lastTopic->GetSubcategory()->SetCategory(new ForumCategory($category));
                                    }
                                }
                            }
                        }
                    }
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/forum_categories.php');
        }


        //----------------------------------------------------------------------------
        //--------------------------TOPICS BY SUB CATEGORY----------------------------
        //----------------------------------------------------------------------------
        public function AllTopics($idSubCategory){

            try {

                // Sous Catégorie
                $dataSubCategory = $this->_model->readOneSubCategory($idSubCategory);

                if (!empty($dataSubCategory)) {

                   $ForumsubCategory = new ForumSubCategory($dataSubCategory);
                }

                // Catégorie
                $dataCategory = $this->_model->readOneCategory($ForumsubCategory->getCategory());

                if (!empty($dataCategory)) {

                    $ForumCategory = new ForumCategory($dataCategory);
                 }

                // Topics
                $datasTopics = $this->_model->readAllTopics($idSubCategory);

                $topics =[];

                if (count($datasTopics) > 0) {

                    foreach ($datasTopics as $data) {

                        $topics[] = new ForumTopic($data);
                    }
                }

                // Nb Messages / User
                if (!empty($topics)) {
                    
                    foreach ($topics as $topic) {

                        $nbMessages = $this->_model->nbMessages($topic->getId());
                        $topic->setNbMessages($nbMessages);

                        $userModel = new UserModel;
                        $data = $userModel->readOne($topic->getUser());
                        $topic->setUser(new User($data));
                    }
                }

                // Last Message 
                $LastMessages = [];
          
                if (!empty($topics)) {
                    foreach ($topics as $topic) {
                        $data = $this->_model->readLastMessage($topic->getId());
                        if (!empty($data)) {
                            $LastMessages[] = new ForumMessage($data);
                        } 
                    }
                }


            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/forum_topics.php');
        }

        //----------------------------------------------------------------------------
        //---------------------------------ADD TOPIC----------------------------------
        //----------------------------------------------------------------------------
        public function newTopic($post){

            try {
                $subcategory = $post['subcategory'];

                if (!empty($post['subject']) && !empty($post['content']) && !empty($post['user']) && !empty($post['subcategory'])) {

                    $msg = $this->_model->addTopic($post['subject'], $post['content'], $post['user'], $post['subcategory']);

                    if (ctype_digit($msg))  {
                        # code...
                        $idNewTopic = $msg;

                        header('Location:/Devign_2/ForumTopics/Topic/'.$idNewTopic);
                        exit();
                    } else {

                        header('Location:/Devign_2/ForumCategory/AllTopics/'.$subcategory.'/'.$msg);
                        exit();
                    }

                }else {
                    $msg = 'Veuillez remplir tous les champs';
                }

                    header('Location:/Devign_2/ForumCategory/AllTopics/'.$subcategory.'/'.$msg);
                    exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }
    }
