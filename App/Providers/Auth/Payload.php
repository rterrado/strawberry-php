<?php

    namespace App\Providers\Auth;

    class Payload {

        public static function parse(string $token)
        {
            $tokenParts = explode('.', $token);
            if ( ! isset( $tokenParts[1] ) ) return false;

            return json_decode(base64_decode($tokenParts[1]), TRUE);
        }

    }
