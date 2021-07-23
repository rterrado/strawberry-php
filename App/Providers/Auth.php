<?php

    namespace App\Providers;
    use \App\Providers\Auth\Validate as Validate;
    use \App\Providers\Auth\Token as Token;
    use \App\Engines\Request as Request;


    class Auth extends Validate {

        public static function create(array $payload): string
        {
            $generate = new Token();
            $payload['exp'] = ((new \DateTime())->modify('+10 minutes')->getTimestamp());
            $token = $generate->setPayload($payload)->generateToken();
            return $token;
        }

        public static function request(Request $request): void
        {
            $request->isAuth    = false;
            $request->isProceed = false;

            if (!$request->isValid) return;

            $request->providers()->response()->hook();

            if(!\ResponseProvider::REQUIRES_AUTH){
                $request->isProceed = true;
                if (!isset($request->query()->token)) return;
                $request->isAuth = Validate::token($request->query()->token);
                return;
            }

            if (!isset($request->query()->token)) return;

            $isAuthorized  = Validate::token($request->query()->token);
            $hasPermission = Validate::permissions($request->query()->token, \ResponseProvider::PERMISSION);

            if (!$isAuthorized) return;
            if (!$hasPermission) return;

            $request->isAuth    = true;
            $request->isProceed = true;
            return;

        }

    }
