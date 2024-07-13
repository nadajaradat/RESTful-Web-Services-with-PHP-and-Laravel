# RESTful Web Services with PHP and Laravel

## Table of Contents
1. [Introduction](#introduction)
2. [Requirements](#requirements)
3. [Setting Laravel Up](#setting-laravel-up)
4. [Deriving API Endpoints](#deriving-api-endpoints)

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
