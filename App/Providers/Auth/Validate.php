<?php

    namespace App\Providers\Auth;

    class Validate {

        protected static function token($token): bool
        {
            $JWTValidator = new \App\Providers\Auth\Token();
            return $JWTValidator->setToken($token)->validate() === \App\Providers\Auth\Token::TOKEN_VALID;
        }

        public static function permissions( $token, $accessCode ): bool
        {
            $tokenParts = explode('.', $token);
            if ( ! isset( $tokenParts[1] ) ) return false;

            $tokenPayload = json_decode(base64_decode($tokenParts[1]), TRUE);
            if ( ! isset ( $tokenPayload["role"] ) ) return false;

            $permissions = explode("::", $tokenPayload["role"] );
            return in_array ( $accessCode, $permissions, TRUE ); 
        }

    }
