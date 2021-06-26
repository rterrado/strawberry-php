<?php

    namespace App\Providers;

    class Service {

        private $name;

        public function name(string $name = null)
        {
            if ( $name === null ) return $this->name;
            $this->name = $name;
            return null;
        }

    }
