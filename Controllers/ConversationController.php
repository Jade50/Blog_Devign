<?php

    class ConversationController {

        private $_model;

        // à chaque instanciation du controller, il instanciera le model
        public function __construct(){

            try {
                
                $this->_model = new ConversationModel;

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //-----------------------------CREATE CONVERSATION----------------------------
        //----------------------------------------------------------------------------
        public function createConversation($post){

            try {

                if (!empty($post['usr-from']) && !empty($post['usr-to'])) {
                    
                    $msg = $this->_model->addConversation($post['usr-from'], $post['usr-to']);

                    header('Location:/Devign_2/Conversation/showConversation/'.$msg);
                    exit();
                }

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //-----------------------------ONE CONVERSATIONS------------------------------
        //----------------------------------------------------------------------------

        public function showConversation($idConv){

            try {

                $userModel = new userModel;
                $user = $userModel->readOne($_SESSION['devign']['userId']);
                $user = new User($user);

                $conv = $this->_model->readOneConversation($idConv);
                $conv = new Conversation($conv);

                // Messages
                $messageModel = new MessageModel;
                $datasMessages = $messageModel->readAllMessages($idConv);

                $messages = [];

                if (!empty($datasMessages)) {
                    foreach ($datasMessages as $data) {
                       $messages[] = new Message($data);
                    }
                }

                if (!empty($messages)) {
                    foreach ($messages as $message) {
                        $userFrom = $userModel->readOne($message->getUserfrom());
                        $userFrom = new User($userFrom);
                        $message->setUserfrom($userFrom);
                        if ($message->getUserfrom()->getId() == $_SESSION['devign']['userId']) {
                            $message->setClass('connected-user');
                        } else {
                            $message->setClass('other-user');
                        }
                    }
                }
  

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/conversation.php');
        }
    
        //----------------------------------------------------------------------------
        //-----------------------------ALL CONVERSATIONS------------------------------
        //----------------------------------------------------------------------------

        public function allConversations($idUser){

            try {

                $messageModel = new MessageModel;

                $userModel = new userModel;
                $user = $userModel->readOne($_SESSION['devign']['userId']);
                $user = new User($user);

                $datasconv = $this->_model->readAllConversations($idUser);

                $convs = [];

                if (!empty($datasconv)) {
                    foreach ($datasconv as $data) {
                       $convs[] = new Conversation($data);
                    }
                }

                if (!empty($convs)) {
                    foreach ($convs as $conv) {

                        $userOne = $userModel->readOne($conv->getUserone());
                        $userOne = new User($userOne);
                        $conv->setUserone($userOne);

                        $userTwo = $userModel->readOne($conv->getUsertwo());
                        $userTwo = new User($userTwo);
                        $conv->setUsertwo($userTwo);

                        $nbMessages = $messageModel->nbMessages($conv->getId());
                        $conv->setNbmessages($nbMessages);

                        $lastMessage = $messageModel->readLastmessage($conv->getId());
                        $lastMessage = new Message($lastMessage);
                        $conv->setLastmessage($lastMessage);

                        $userLastMessage = $userModel->readOne($conv->getLastmessage()->getUserfrom());
                        $userLastMessage = new User($userLastMessage);
                        $conv->getLastMessage()->setUserfrom($userLastMessage);
                    }
                }
  

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }

            include('./Views/all_conversations.php');
        }

    }
    
