<?php

    namespace App\Engines;

    class Parser {

        protected static function uri(Providers $providers): void
        {
            $uris = explode("/", $_SERVER["REQUEST_URI"]);

            $providers->response()->gateway($uris[2] ?? "invalid");
            $providers->response()->version($uris[3] ?? "invalid");
            $providers->service()->name($uris[5] ?? "invalid");
        }

        protected static function query(Object $query): void
        {
            parse_str($_SERVER["QUERY_STRING"], $data);
            if (!empty($data)) {
                Self::map ($data, $query );
            }
        }

        protected static function payload (Object $payload): void
        {
            $body = urldecode(file_get_contents('php://input'));
            $data = json_decode($body, true);
            if ( json_last_error() === JSON_ERROR_NONE ) {
                Self::map ($data, $payload);
                $payload->isEmpty = false;
                return;
            }

            $bodyPairs = explode("&", $body);

            foreach ($bodyPairs as $bodyPair) {
                $keyVal = explode("=", $bodyPair);
                if (isset($keyVal[1])){
                    $tmp = $keyVal[0];
                    $payload->$tmp = htmlspecialchars($keyVal[1]);
                }
            }

            return;
        }

        protected static function files(Object $files):void
        {
            $files->isEmpty = true;
            $infos = ["name", "type", "tmp_name", "error", "size"];
            foreach ($infos as $info ) {
                $files->$info = $_FILES["file"][$info] ?? null;
            }
            if (  isset ( $_FILES['file']['name'] ) ) $files->isEmpty = false;
            return;
        }

        private static function map(array $data, Object $object)
        {
            foreach ($data as $key => $value) {
                $object->$key = htmlspecialchars($value);
            }
        }



    }
