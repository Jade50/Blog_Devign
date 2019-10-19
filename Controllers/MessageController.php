<?php

    class MessageController {

        private $_model;

        // à chaque instanciation du controller, il instanciera le model
        public function __construct(){

            try {
                
                $this->_model = new MessageModel;

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }

        //----------------------------------------------------------------------------
        //--------------------------------SEND MESSAGE--------------------------------
        //----------------------------------------------------------------------------

        public function sendMessage($post){

            try {

                if (!empty($post['content'])) {
                    
                    $msg = $this->_model->sendMessage($post['content'], $post['usr-from'], $post['conv']);

                    header('Location:/Devign_2/Conversation/showConversation/'.$post['conv']);
                    exit();

                } else {

                    $msg = 'Veuillez remplir le champ';
                    header('Location:/Devign_2//Conversation/showConversation/'.$post['conv'].'/'.$msg);
                    exit();
                }
  

            } catch (PDOException $e) {

                throw new Exception($e->getMessage(), 0, $e);
            }
        }


    }
    
