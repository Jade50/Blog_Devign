<?php

    class ForumCategory {

        private $_id;
        private $_name;
        private $_idSubCategory;
        private $_NameSubCategory;
        private $_pictoSubCategory;

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

        public function getIdsubcategory(){
            return $this->_idSubCategory;
        }

        public function setIdsubcategory($idSubCategory){
            $this->_idSubCategory = $idSubCategory;
            return $this;
        }

        public function getNamesubcategory(){
            return $this->_nameSubCategory;
        }

        public function setNamesubcategory($nameSubCategory){
            $this->_nameSubCategory = $nameSubCategory;
            return $this;
        }

        public function getPictosubcategory(){
            return $this->_pictoSubCategory;
        }

        public function setPictosubcategory($pictoSubCategory){
            $this->_pictoSubCategory = $pictoSubCategory;
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