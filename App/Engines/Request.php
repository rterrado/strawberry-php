<?php

    namespace App\Engines;
    use \App\Engines\Providers as Providers;

    class Request {

        private $providers;
        private $query;
        private $payload;
        private $files;

        public function __construct()
        {
            $this->providers = new Providers;
            $this->query     = new Class {};
            $this->payload   = new Class {};
            $this->files     = new Class {};
        }

        public function providers(): Providers
        {
            return $this->providers;
        }

        public function query()
        {
            return $this->query;
        }

        public function payload()
        {
            return $this->payload;
        }

        public function files()
        {
            return $this->files;
        }

    }
