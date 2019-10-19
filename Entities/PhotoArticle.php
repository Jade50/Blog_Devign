<?php

    class PhotoArticle {

        private $_id;
        private $_article;
        private $_photoName;

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

        public function getArticle(){
            return $this->_article;
        }

        public function setArticle($article){
            $this->_article = $article;
            return $this;
        }

        public function getPhotoname(){
            return $this->_photoName;
        }

        public function setPhotoname($photoName){
            $this->_photoName = $photoName;
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