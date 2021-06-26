<?php

    namespace App\Providers;

    class Response {

        private $gateway;
        private $version;
        private $path;

        public function gateway(string $gateway = null)
        {
            if ( $gateway === null ) return $this->gateway;
            $this->gateway = $gateway;
            return null;
        }

        public function version(string $version = null)
        {
            if ( $version === null ) return $this->version;
            $this->version = $version;
            return null;
        }

        public function register(string $path)
        {
            $this->path = $path;
        }

        public function hook()
        {
            if (file_exists($this->path)) {
                require_once $this->path;
            }
        }

    }
