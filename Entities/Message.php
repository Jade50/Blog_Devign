<?php

    class Message {

        private $_id;
        private $_message;
        private $_userFrom;
        private $_conv;
        private $_class;
        private $_date;

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

        public function getMessage(){
            return $this->_message;
        }

        public function setMessage($message){
            $this->_message = $message;
            return $this;
        }

        public function getUserfrom(){
            return $this->_userFrom;
        }

        public function setUserfrom($userFrom){
            $this->_userFrom = $userFrom;
            return $this;
        }

        public function getConv(){
            return $this->_conv;
        }

        public function setConv($conv){
            $this->_conv = $conv;
            return $this;
        }

        public function getClass(){
            return $this->_class;
        }

        public function setClass($class){
            $this->_class = $class;
            return $this;
        }

        public function getDate(){
            return $this->_date;
        }

        public function setDate($date){
            $this->_date = $date;
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