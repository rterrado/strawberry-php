<?php

    namespace App\Providers\Responses;
    use \App\Engines\Request as Request;

    interface ResponseProviderInterface {

        public static function render(Request $request, bool $isAuth);

    }
