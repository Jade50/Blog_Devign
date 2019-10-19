<?php

    class Article {

        private $_id;
        private $_title;
        private $_text;
        private $_date;
        private $_user;
        private $_lastImg;
        private $_nbComments;
        private $_category;

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

        public function getTitle(){
            return $this->_title;
        }

        public function setTitle($title){
            $this->_title = $title;
            return $this;
        }

        public function getText(){
            return $this->_text;
        }

        public function setText($text){
            $this->_text = $text;
            return $this;
        }

        public function getDate(){
            return $this->_date;
        }

        public function setDate($date){
            $this->_date = $date;
            return $this;
        }

        public function getUser(){
            return $this->_user;
        }

        public function setUser($user){
            $this->_user = $user;
            return $this;
        }

        public function getLastimg(){
            return $this->_lastImg;
        }

        public function setLastimg($lastImg){
            $this->_lastImg = $lastImg;
            return $this;
        }

        public function getNbcomments(){
            return $this->_nbComments;
        }

        public function setNbcomments($nbComments){
            $this->_nbComments = $nbComments;
            return $this;
        }

        public function getCategory(){
            return $this->_category;
        }

        public function setCategory($category){
            $this->_category = $category;
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