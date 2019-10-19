<?php

    class ForumTopicsController {

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
        //------------------------------READ ONE TOPIC--------------------------------
        //----------------------------------------------------------------------------
        public function Topic($idTopic){

            try {

                // Get Topic
                $datastopic = $this->_model->readOneTopic($idTopic);

                if (!empty($datastopic)) {

                   $topic = new ForumTopic($datastopic);
                }

                // Sous Catégorie
                $dataSubCategory = $this->_model->readOneSubCategory($topic->getSubcategory());

                if (!empty($dataSubCategory)) {

                   $ForumsubCategory = new ForumSubCategory($dataSubCategory);
                }

                // Catégorie
                $dataCategory = $this->_model->readOneCategory($ForumsubCategory->getCategory());

                if (!empty($dataCategory)) {

                    $ForumCategory = new ForumCategory($dataCategory);
                 }

                // Créateur du topic
                $userModel = new UserModel;

                $dataTopicCreator = $userModel->readOne($topic->getUser());

                if (!empty($dataTopicCreator)) {

                    $topicCreator = new User($dataTopicCreator);
                    $topic->setUser($topicCreator);
                 }

                 // Messages 
                 $datasMessages = $this->_model->readAllMessages($topic->getId());

                 $messages =[];
 
                 if (count($datasMessages) > 0) {
 
                     foreach ($datasMessages as $data) {
 
                         $messages[] = new ForumMessage($data);
                     }
                 }

                 if (!empty($messages)) {
                     foreach ($messages as $message) {

                        $userModel = new UserModel;
                        $dataMessageCreator = $userModel->readOne($message->getUser());
                        $messageCreator = new User($dataMessageCreator);
                        $message->setUser($messageCreator);
                     }
                 }


            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/forum_topic.php');
        }

        //----------------------------------------------------------------------------
        //---------------------------------ADD MESSAGE-----------------------------------
        //----------------------------------------------------------------------------
        public function newMessage($post){

            try {
                $idTopic = $post['topic'];

                if (!empty($post['message']) && !empty($post['user']) && !empty($post['topic'])) {

                    $msg = $this->_model->addMessage($post['message'], $post['user'], $post['topic']);

                    header('Location:/Devign_2/ForumTopics/Topic/'.$idTopic.'/'.$msg);
                    exit();
               
                    }else {
                        $msg = 'Veuillez remplir tous les champs';
                    }

                    header('Location:/Devign_2/ForumTopics/Topic/'.$idTopic.'/'.$msg);
                    exit();

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }
    }
