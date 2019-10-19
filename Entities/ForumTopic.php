<?php

    class ForumTopic {

        private $_id;
        private $_subCategory;
        private $_subject;
        private $_content;
        private $_date;
        private $_statut;
        private $_user;
        private $_messages;
        private $_nbMessages;

        public function __construct($data){
            $this->hydrate($data);
        }

        public function getId(){
            return $this->_id;
        }

        public function setId($id){
            $this->_id = $id;
            return $this;
        }

        public function getSubcategory(){
            return $this->_subCategory;
        }

        public function setSubcategory($subCategory){
            $this->_subCategory = $subCategory;
            return $this;
        }

        public function getSubject(){
            return $this->_subject;
        }

        public function setSubject($subject){
            $this->_subject = $subject;
            return $this;
        }

        public function getContent(){
            return $this->_content;
        }

        public function setContent($content){
            $this->_content = $content;
            return $this;
        }

        public function getDate(){
            return $this->_date;
        }

        public function setDate($date){
            $this->_date = $date;
            return $this;
        }

        public function getStatue(){
            return $this->_statut;
        }

        public function setStatue($statut){
            $this->_statut = $statut;
            return $this;
        }

        public function getUser(){
            return $this->_user;
        }

        public function setUser($user){
            $this->_user = $user;
            return $this;
        }

        public function getMessages(){
            return $this->_messages;
        }

        public function setMessages($messages){
            $this->_messages = $messages;
            return $this;
        }

        public function getNbMessages(){
            return $this->_nbMessages;
        }

        public function setNbMessages($nbMessages){
            $this->_nbMessages = $nbMessages;
            return $this;
        }

        public function hydrate($data){

            // $this->setLogin($data['usr_login']);

            foreach ($data as $key => $value) {
                
                $methodName = 'set'.ucfirst($key);

                if (method_exists($this, $methodName)) {
                    $this->$methodName($value);
                }
            }
        }
    }

?>