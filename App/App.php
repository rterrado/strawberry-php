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

        /**
         * Boots the application
         * @return void
         * @since v1.0.0
         */
        public function boot(): void {
            Boot::method( $this->request );
            Boot::meta( $this->request->providers() );
            Boot::query( $this->request->query() );
            Boot::payload( $this->request->payload() );
            Boot::files( $this->request->files() );
        }

        /**
         * Validates the request
         * @return void
         * @since v1.0.0
         */
        public function validate(): void {
            Validate::providers( $this->request );
        }

        /**
         * Authenticates the request
         * @return void
         * @since v1.0.0
         */
        public function authenticate(): void {
            Auth::request( $this->request );
        }

        /**
         * Serves the request
         * @return void
         * @since v1.0.0
         */
        public function serve(): void {
            if ( ! $this->request->isValid ) {
                ResponseSchema::abort(
                    "Exception::Response Provider does not exist",
                    400,
                    true);
                return;
            }

            if ( ! $this->request->isProceed ) {
                ResponseSchema::abort(
                    "Unauthorized",
                    401,
                    true);
                return;
            }

            try {
                \ResponseProvider::render ( $this->request, $this->request->isAuth );
            }
            catch (\Exception $e) {
                ResponseSchema::abort(
                    "Exception::Server Error: ".$e->getMessage(),
                    500,
                    true);
            }

        }

    }
