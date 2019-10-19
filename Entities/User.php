<?php

    class User {

        private $_id;
        private $_name;
        private $_firstName;
        private $_mail;
        private $_about;
        private $_roleId;
        private $_inscription;
        private $_avatar;

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

        public function getFirstName(){
            return $this->_firstName;
        }

        public function setFirstName($firstName){
            $this->_firstName = $firstName;
            return $this;
        }

        public function getMail(){
            return $this->_mail;
        }

        public function setMail($mail){
            $this->_mail = $mail;
            return $this;
        }

        public function getAbout(){
            return $this->_about;
        }

        public function setAbout($about){
            $this->_about = $about;
            return $this;
        }

        public function getRoleId(){
            return $this->_roleId;
        }

        public function setRoleId($roleId){
            $this->_roleId = $roleId;
            return $this;
        }

        public function getRoleName(){
            return $this->_roleName;
        }

        public function setRoleName($roleName){
            $this->_roleName = $roleName;
            return $this;
        }

        public function getInscription(){
            return $this->_inscription;
        }

        public function setInscription($inscription){
            $this->_inscription = $inscription;
            return $this;
        }

        public function getAvatar(){
            return $this->_avatar;
        }

        public function setAvatar($avatar){
            $this->_avatar = $avatar;
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