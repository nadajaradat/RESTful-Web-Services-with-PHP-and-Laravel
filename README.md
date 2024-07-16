
# RESTful Web Services with PHP and Laravel

## Table of Contents
1. [Introduction](#introduction)
2. [Requirements](#requirements)
3. [Setting Laravel Up](#setting-laravel-up)
4. [Deriving API Endpoints](#deriving-api-endpoints)
5. [Routing](#routing)
6. [Request Handling and Responses](#request-handling-and-responses)
7. [API Documentation](#api-documentation)

## Introduction
This repository contains the code and resources for learning RESTful Web Services with PHP and Laravel. It covers the creation and management of RESTful APIs using Laravel.

### What are RESTful Services?
RESTful Services provide uniform, standardized access with clear request requirements and response structures. They enable us to know which data to expect and how the server should handle this data. With standardized access and clear responses, it allows us to manage different applications accessing the service, such as smartphone apps.

### RESTful Service Structure
![RESTful Service Structure](https://github.com/nadajaradat/RESTful-Web-Services-with-PHP-and-Laravel/assets/86928581/e3ea23ca-4868-451a-aa7c-a95e6b0040ac)

## Requirements
- PHP 7.2.5 or higher
- Composer
- MySQL or another database supported by Laravel
- Node.js and npm (for frontend assets, if applicable)
- Git
- Postman

## Setting Laravel Up
To set up Laravel with Breeze and APIs, follow the instructions in this [article](https://blog.devgenius.io/laravel-11-breeze-auth-api-adding-an-api-route-to-laravel-11-project-f8c4e68e650a).

1. Create a Laravel project with Composer:
    ```bash
    composer create-project laravel/laravel PROJECT_FOLDER
    ```

2. Configure the `.env` file with your database settings:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

3. Install Laravel Breeze:
    ```bash
    composer require laravel/breeze:2.0.0
    php artisan breeze:install
    ```

4. Specify the following settings:
    - Blade stack
    - No for dark mode support
    - 1 for PHPUnit testing framework

5. Run migrations:
    ```bash
    php artisan migrate
    ```

## Deriving API Endpoints
Refer to the [Decomposition of Microservices Architecture](https://medium.com/design-microservices-architecture-with-patterns/decomposition-of-microservices-architecture-c8e8cec453e) article to learn how to decompose microservices into a microservices architecture.

### Main HTTP Methods
- **GET:** Retrieve data from the database
- **POST:** Insert data into the database
- **PUT:** Update data in the database by overwriting an old record
- **PATCH:** Update data in the database by overwriting fields of an old record
- **DELETE:** Delete data from the database

### Protect Routes
Identify sensible API endpoints and ensure they are authenticated when implemented.

## Routing

### RESTful Routes
For detailed information about routes, refer to the [Laravel routing documentation](https://laravel.com/docs/11.x/routing).

**Basic Route Example:**
In `web.php`:
```php
use Illuminate\Support\Facades\Route;
 
Route::get('/greeting', function () {
    return 'Hello World';
});
```

Access the route in the browser to see the output.

![Route Output](https://github.com/user-attachments/assets/e92a7c20-90e0-442f-894d-8a39016f8b36)

## Request Handling and Responses

Create a new controller for authentication:
```bash
php artisan make:controller Api/AuthController
```

Edit the newly created file (`app\Http\Controllers\Api\AuthController.php`) as follows:
```php
<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
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
        $created_user = User::where('email', '=', $request->email)->first();

        return response()->json([
            'user' => $created_user,
            'status' => 'registered',
            'verified' => false
        ], 200);
    }

    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'user' => null,
                'message' => 'Invalid login details',
                'status' => 'failed'
            ], 200);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $user_loggedin = [
            'id' => $user->id,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'status' => 'loggedin'
        ];

        if ($user->email_verified_at != null) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $user_loggedin['user_token'] = $token;
            $user_loggedin['token_type'] = 'Bearer';
        }

        return response()->json($user_loggedin, 200);
    }
}
```

Enable API routing by running:
```bash
php artisan install:api
```

This command creates the `routes/api.php` file. To initialize controllers with models and policies, use:
```bash
php artisan make:controller MeetingController --resource --model=Meeting
php artisan make:policy MeetingPolicy --model=Meeting
```

## Request Handling and Responses
This is the request-response flow in Laravel:
![Request Response Flow](https://github.com/user-attachments/assets/56ce8ca7-76e3-4dbe-910b-2fff7274dd46)

## API Documentation
For detailed API documentation, refer to the [Postman documentation](https://documenter.getpostman.com/view/33872204/2sA3kRHiRd#intro).
