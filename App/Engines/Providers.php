<?php

    namespace App\Engines;
    use \App\Providers\Response as Response;
    use \App\Providers\Service as Service;

    class Providers {

        private $service;
        private $response;
        private $auth;

        public function __construct()
        {
            $this->response = new Response;
            $this->service  = new Service;
        }

        public function response() : \App\Providers\Response
        {
            return $this->response;
        }

        public function service(): \App\Providers\Service
        {
            return $this->service;
        }

    }
