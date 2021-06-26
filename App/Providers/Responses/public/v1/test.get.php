<?php

    use \App\Engines\Request as Request;
    use \App\ResponseSchema as ResponseSchema;

    class ResponseProvider implements \App\Providers\Responses\ResponseProviderInterface {

        public const REQUIRES_AUTH = false;
        public const PERMISSION    = "BASIC";

        public static function render ( Request $request, bool $isAuth ) {

            $response = new ResponseSchema;
            $response->timer();
            $response->json([
                "user_id" => $request->query()->userid,
                "first_name" => "Ken",
                "last_name" => "Terrado",
                "email" =>"terrado.ken@gmail.com",
                "address" => "Consolacion, Cebu 6001"
            ]);
            $response->send();
        }

    }
