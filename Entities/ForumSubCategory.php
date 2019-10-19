<?php

    class ForumSubCategory {

        private $_id;
        private $_name;
        private $_desc;
        private $_category;
        private $_picto;
        private $_nbTopics;

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

        public function getName(){
            return $this->_name;
        }

        public function setName($name){
            $this->_name = $name;
            return $this;
        }

        public function getCategory(){
            return $this->_category;
        }

        public function setCategory($category){
            $this->_category = $category;
            return $this;
        }

        public function getPicto(){
            return $this->_picto;
        }

        public function setPicto($picto){
            $this->_picto = $picto;
            return $this;
        }

        
        public function getNbtopics(){
            return $this->_nbTopics;
        }

        public function setNbtopics($nbTopics){
            $this->_nbTopics = $nbTopics;
            return $this;
        }

        public function getDesc(){
            return $this->_desc;
        }

        public function setDesc($desc){
            $this->_desc = $desc;
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