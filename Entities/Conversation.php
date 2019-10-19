<?php

    class Conversation {

        private $_id;
        private $_userOne;
        private $_userTwo;
        private $_nbMessages;
        private $_lastMessage;

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

        public function getUserone(){
            return $this->_userOne;
        }

        public function setUserone($userOne){
            $this->_userOne = $userOne;
            return $this;
        }

        public function getUsertwo(){
            return $this->_userTwo;
        }

        public function setUsertwo($userTwo){
            $this->_userTwo = $userTwo;
            return $this;
        }

        public function getNbmessages(){
            return $this->_nbMessages;
        }

        public function setNbmessages($nbMessages){
            $this->_nbMessages = $nbMessages;
            return $this;
        }

        public function getLastmessage(){
            return $this->_lastMessage;
        }

        public function setLastmessage($lastMessage){
            $this->_lastMessage = $lastMessage;
            return $this;
        }

        public function hydrate($data){

            foreach ($data as $key => $value) {
                
                $methodName = 'set'.ucfirst($key);

                if (method_exists($this, $methodName)) {
                    $this->$methodName($value);
                }
            }
        }
    }

?>