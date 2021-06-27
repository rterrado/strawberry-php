# strawberry-php
A lightweight PHP-API Framework

Author: Kenjie Terrado 2021

For contribution request, please send me an email: terradokenjie@gmail.com

#### In a Nutshell
StrawberryPHP processes requests in the most simplest manner. `index.php`, as the entry point of all the requests, descriptively outlines how a request is being handled. Once a request is received, `index.php` creates a new instance of the application, boots the application, validates the request, authenticates and serves it. 

#### API Path Parameters
StrawberryPHP follows a strict path parameter structure. Alteration in the order of the path parameters will result in a bad request. The path parameters should be structured in  the following way:

``` 
/api/[RESPONSE GATEWAY]/[API VERSION]/[METHOD]/[SERVICE PROVIDER]
```

URL parameter should be passed by adding a `DATA` path parameter as shown in an example below:

```
/api/public/v1/get/user/data?id=userid
```
#### API Request Method
While request method is being passed as path parameter, StrawberryPHP will only read the actual request method being sent by the client. 

#### JSON Web Token Authorization 
JWT is the default Auth Provider of StrawberryPHP. Tokens can be passed as a `token` query parameter with each request.

#### Authentication 
Whether the resource requires authentication or what the requester permission requires to be, the Auth provider will only do as required by the Response Provider.

```
public const REQUIRES_AUTH = false;
public const PERMISSION    = "BASIC";
```
Permission is being extracted from the JWT `role` payload. If the role have several permissions, they should be sent as one string in the `role` payload, but separated by `::`, for example: `BASIC::WEB::ADMIN`

NOTE: Whether the `REQUIRES_AUTH` value is `true` or `false`, the default Auth provider will still try to authenticate the request. This is to allow the Response Provider to generate payload exclusive to an authenticated request, yet letting unauthenticated request go through.


## Resource Creation
This section will walk you through in creating an API response. In this section, we will be creating a resource for an API call below: 

```
/api/public/v1/get/user/data?email=terradokenjie@gmail.com
```

#### Response Gateway
The response gateway gives label to all the resouces. In our example, the `public` response gateway can signify that all the API call that goes through it do not require authentication. While you are free to create whatever name for your response gateway, it's best to give it a name that serves it purpose. 

To create a response gateway, we will need to create a directory in the Responses folder: \App\Providers\Responses

#### Versions
Versions are directories in your response gateway folder. With our example API call, we should have created a directory: \App\Providers\Responses\public\v1

#### Response Provider 
Response Provider, as its name suggests, provides the response to an API call. Response Provider is where the actual action takes place, more specifically, in the render method. With each requests, StrawberryPHP will look for a Response Provider that corresponds to the request, rejects the request if it isn't found, and if it's found, calls its render method. 

```
public static function render ( Request $request, bool $isAuth ) {
    // action takes place in here
}
```
The request object is passed as an argument to the Response Provider render method along a boolen value (`$isAuth`) the tells whether the request is authenticated or not. 

The file name of the Response Provider plays a big role in routing the request. The file name of the Response Provider should have the following format: 

```
[service provider].[request method].php
```
In our example API url, we will need to create a Response Provider that has the following file name: 
```
user.get.php
```
In creating a Response Provider, it first should need to make sure that it implements the Response Provider Interface. 

#### Response Provider Interface 

```
<?php

    namespace App\Providers\Responses;
    use \App\Engines\Request as Request;

    interface ResponseProviderInterface {

        public static function render(Request $request, bool $isAuth);

    }
 ```
All Response Providers should implement the Response Provider interface. 

#### Query Parameters and Payload 
You can access the query parameters and payload inside the Response Provider render method using the Request object: 
```
$request->query()->id
$request->payload()->email
```


#### Response Schema
Response schema allows an easy way to send a structured response. Here is an example below: 
```
$response = new \App\ResponseSchema;
$response->timer(); // records and sends execution time
$response->json([  // sends a JSON content
    "user_id" => $request->query()->userid,
    "first_name" => "Ken",
    "last_name" => "Terrado",
    "email" =>"terrado.ken@gmail.com",
    "address" => "Consolacion, Cebu 6001"
]);
$response->send();
```


