<?php

    class AppController {

        protected $controller = 'homeController';
        protected $method = 'index';
        protected $params = [];
        protected $post;

        public function __construct($post = null){

            $url = $this->parseUrl();

            if (file_exists('./Controllers/'.$url[0].'Controller.php')) {
                
                $this->controller = $url[0].'Controller';

                if (!empty($post)) {
                    $this->post = $post;
                }
            } 

            $this->controller = new $this->controller;

            if (isset($url[1])) {

                if (method_exists($this->controller, $url[1])) {

                    $this->method = $url[1];
                }
            }

            if (isset($url[2])) {
                // unset($url[0]);
                // unset($url[1]);
                $this->params = $url[2];
            }


            if (!empty($this->post)) {
    
                call_user_func_array([$this->controller, $this->method], array($this->post));

            } else if (!empty($this->params)) {

                call_user_func_array([$this->controller, $this->method], [$this->params]);

            } else {
                call_user_func([$this->controller, $this->method]);
            }

        }

        public function parseUrl(){

            if (isset($_GET['url'])) {

                $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

                return $url;
            }
        }
    }