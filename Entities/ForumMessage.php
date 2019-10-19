<?php

    class ForumMessage {

        private $_id;
        private $_date;
        private $_content;
        private $_user;
        private $_topic;

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

        public function getDate(){
            return $this->_date;
        }

        public function setDate($date){
            $this->_date = $date;
            return $this;
        }

        public function getContent(){
            return $this->_content;
        }

        public function setContent($content){
            $this->_content = $content;
            return $this;
        }

        public function getUser(){
            return $this->_user;
        }

        public function setUser($user){
            $this->_user = $user;
            return $this;
        }

        public function getTopic(){
            return $this->_topic;
        }

        public function setTopic($topic){
            $this->_topic = $topic;
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