<?php

    namespace App;
    use \App\Engines\Boot as Boot;
    use \App\Engines\Validate as Validate;
    use \App\Providers\Auth as Auth;
    use \App\Engines\Request as Request;
    use \App\ResponseSchema as ResponseSchema;

    class App extends Boot {

        private $request;

        public function __construct()
        {
            $this->request = new Request;
        }

        public function boot(): void
        {
            Boot::method( request: $this->request );
            Boot::meta( providers: $this->request->providers() );
            Boot::query( query: $this->request->query() );
            Boot::payload( payload: $this->request->payload() );
            Boot::files( files: $this->request->files() );
        }

        public function validate(): void {
            Validate::providers( request: $this->request );
        }

        public function authenticate(): void {
            Auth::request( request: $this->request );
        }

        public function serve(): void {

            if (!$this->request->isValid) {
                ResponseSchema::abort(
                    exception:"Exception::Response Provider does not exist",
                    time: true );
                return;
            }

            if (!$this->request->isProceed) {
                ResponseSchema::abort(
                    exception:"Unauthorized",
                    code: 401,
                    time: true );
                return;
            }

            try {
                \ResponseProvider::render($this->request, $this->request->isAuth);
            }
            catch (\Exception $e) {
                ResponseSchema::abort(
                    exception:"Exception::Server Error: ".$e->getMessage(),
                    code: 500,
                    time: true );
            }

        }

    }
