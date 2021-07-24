<?php

    namespace App\Engines;

    class Validate {

        public static function providers(Request $request): void
        {
            $method    = $request->method;
            $providers = $request->providers();

            $request->isValid = Self::response(
                $providers,
                $method);
        }

        private static function find(string $path): bool
        {
            if (file_exists($path)) return true;
            return false;
        }

        private static function response(Providers $providers, string $method): bool
        {
            $gateway  = $providers->response()->gateway();
            $version  = $providers->response()->version();
            $service  = $providers->service()->name();
            $provider = $service.".".$method.".php";

            $path = Self::build([$gateway, $version, $provider]);
            $providers->response()->register($path);
            return Self::find($path);
        }

        private static function build(array $directories): string
        {
            $path = $_SERVER["DOCUMENT_ROOT"];
            foreach ($directories as $directory) {
                $path = $path."/".$directory;
            }
            return $path;
        }

    }
