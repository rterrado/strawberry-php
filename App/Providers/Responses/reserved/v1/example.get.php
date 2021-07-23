<?php

    use \App\Engines\Request as Request;
    use \App\Providers\Auth as Auth;
    use \App\Providers\Auth\Payload as Payload;
    use \App\ResponseSchema as ResponseSchema;

    class ResponseProvider implements \App\Providers\Responses\ResponseProviderInterface {

        public const REQUIRES_AUTH = true;
        public const PERMISSION    = "WEB";

        public static function render(Request $request, bool $isAuth)
        {
            
        }

    }
