<?php

    namespace App\Engines;
    use \App\Engines\Parser as Parser;

    class Boot extends \App\Engines\Parser {

        protected static function method(Request $request): void
        {
            $request->method = strtolower($_SERVER["REQUEST_METHOD"]);
        }

        protected static function meta(Providers $providers): void
        {
            Parser::uri($providers);
        }

        protected static function query(Object $query): void
        {
            Parser::query($query);
        }

        protected static function payload(Object $payload): void
        {
            Parser::payload($payload);
        }

        protected static function files(Object $files): void
        {
            Parser::files($files);
        }

    }
