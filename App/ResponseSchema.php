<?php

    namespace App;

    class ResponseSchema {

        private $statusCode;
        private $exception;
        private $showResponseTime;

        public function __construct() {
            $this->showResponseTime = false;
        }

        public function code( int $code ) {
            $this->statusCode = $code;
            return;
        }

        public function timer() {
            $this->showResponseTime = true;
        }

        public function exception( string $exception )  {
            $this->exception = $exception;
            return;
        }

        public function json( array $json = null ){
            header('Content-Type: application/json');
            $json["error"] = $this->exception;
            if ($this->showResponseTime) {
                $json["execTime"] = round((microtime(true)-$_SERVER['REQUEST_TIME_FLOAT'])*1000,2);
            }
            echo json_encode($json);
            return;
        }

        public function send(){
            http_response_code($this->statusCode);
        }

        public static function abort(string $exception, int $code = 400, bool $time = false): void
        {
            $response = new \App\ResponseSchema;
            $response->code($code);
            $response->exception($exception);
            if ($time) $response->timer();
            $response->json();
            $response->send();
        }

    }
