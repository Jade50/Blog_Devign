<?php

    class ArticleCategory {

        private $_id;
        private $_name;
        private $_desc;
        private $_nbArticles;

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

        public function getDesc(){
            return $this->_desc;
        }

        public function setDesc($desc){
            $this->_desc = $desc;
            return $this;
        }

        public function getNbarticles(){
            return $this->_nbArticles;
        }

        public function setNbarticles($nbArticles){
            $this->_nbArticles = $nbArticles;
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