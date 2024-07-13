# RESTful Web Services with PHP and Laravel

## Table of Contents
1. [Introduction](#introduction)
2. [Requirements](#requirements)
3. [Setting Laravel Up](#setting-laravel-up)
4. [Deriving API Endpoints](#deriving-api-endpoints)
5. [Routing](#routing)

## Introduction
This repository contains the code and resources for learning RESTful Web Services with PHP and Laravel. It covers the creation and management of RESTful APIs using Laravel.

### What are RESTful Services?
RESTful Services provide uniform, standardized access with clear request requirements and response structure. They allow us to know which data we'll receive so that the server is able to handle this data. With standardized access and clear responses, it lets us handle different applications accessing the service, such as an app on a smartphone.

### RESTful Service Structure
![image](https://github.com/nadajaradat/RESTful-Web-Services-with-PHP-and-Laravel/assets/86928581/e3ea23ca-4868-451a-aa7c-a95e6b0040ac)

## Requirements
- PHP 7.2.5 or higher
- Composer
- MySQL or another database supported by Laravel
- Node.js and npm (for frontend assets, if applicable)
- Git
- Postman

## Setting Laravel Up

I've used this [article](https://blog.devgenius.io/laravel-11-breeze-auth-api-adding-an-api-route-to-laravel-11-project-f8c4e68e650a) to setup laravel with breeze and API's 
1. Create a Laravel project with Composer:
    ```bash
    composer create-project laravel/laravel PROJECT_FOLDER
    ```

2. Configure the `.env` file (database settings):
    - Set up your own database connection details in the `.env` file.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

```
composer require laravel/breeze:2.0.0
php artisan breeze:install
```
Specify the following settings:

Blade stack
No for dark mode support
1 for PHPUnit testing framework

then

```
php artisan migrate
```
## Deriving API Endpoints
you can read 
[Decomposition of Microservices Architecture](https://medium.com/design-microservices-architecture-with-patterns/decomposition-of-microservices-architecture-c8e8cec453e) article, to learn how to Decompose Microservices into Microservices Architecture.

### Main HTTP Methods
- GET: GET data from db
- POST: INSERT data into db
- PUT: UPDATE data in db by overwriting old record
- PATCH: UPDATE data in db by overwriting fields of old record
- DELETE: DELETE data in db
  
### Protect routes
first we need to know sensible API Endpoints, and then when implement its should be authenticated.

## Routing

### RESTful routes
you can read about [routes](https://laravel.com/docs/11.x/routing) from laravel documintaion

**basic routes**
in web.php
``` 
use Illuminate\Support\Facades\Route;
 
Route::get('/greeting', function () {
    return 'Hello World';
});
```

then in the browser

![image](https://github.com/user-attachments/assets/e92a7c20-90e0-442f-894d-8a39016f8b36)

```
php artisan make:controller Api/AuthController
```
then edit as follows:

(file →app\Http\Controllers\Api\AuthController.php)

```
<?php
/* app\Http\Controllers\Api\AuthController.php */
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
class AuthController extends Controller
{
    //
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        $created_user= User::where('email', '=', $request->email)->first();
        return response()->json([
            'user'=>$created_user,
            'stus'=>'registered',
            'verified'=>false], 200);  
    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only("email", "password"))) {
            return response()->json(
                [
                    "user" => Null,
                    "message" => "Invalid login details",
                    "stus" => "failed",
                ],
                200
            );
        }
        $user = User::where("email", $request["email"])->firstOrFail();
        $user_loggedin=[
            'id' => $user->id,
            'email' => $user->email,
            'email_verified_at'=>  $user->email_verified_at, 
            'stus'=>'loggedin'
        ];
        if ($user->email_verified_at != Null) 
            $token = $user->createToken("auth_token")->plainTextToken;
            $user_loggedin['user_token']= $token;
            $user_loggedin['token_type']= 'Bearer';

        return response()->json(
            $user_loggedin,
            200
        );
    }
}
```
now if your application will also offer a stateless API, you may enable API routing using the install:api Artisan command:
```
php artisan install:api
```
the install:api command creates the routes/api.php file
