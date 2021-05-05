## Laravel Task Management App API

This app is a simple task management system that can be used to assign task to a user and track progress through the different checklists on the task

## Installation
1. After cloning the repository, create a `.env` file using `.env.example`
2. Run `composer install`
3. Create database and save the database name and credentials on your `.env` file
4. Run `php artisan key:generate` to generate application keys
5. Run `php artisan migrate` to migrate the tables to your database
6. Run `php artisan db:seed` to populate your database with pre-defined data
7. Run `php artisan test` to test features