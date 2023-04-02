## A repository for studying MVC architecture

### Key Features

- **MVC architecture:** The framework uses the Model-View-Controller (MVC) architectural pattern, which promotes separation of concerns and modularity in the application design.

- **Dynamic routing:** The framework supports dynamic routing, allowing developers to define custom routes for their application.

- **Form validation:** The framework provides built-in form validation capabilities, which allows developers to easily validate user input and prevent common security issues.

- **Templating:** simple and elegant way to create reusable views and layouts. It also supports the @section and @yield directives for flexible view composition.

- **Database:** The framework supports MySQL as the default database driver, providing a seamless integration with the database layer.

- **Migrations:** The framework includes a database migration system, allowing developers to manage database schema changes in a consistent and reproducible manner.

- **Models:** The framework provides support for models, allowing developers to represent and manipulate data as objects.

- **Sessions:** The framework includes built-in support for managing user sessions, allowing developers to easily store and retrieve session data.
  
- **CLI interface** Console interface for creating Controllers and models.

- **Middleware:** The framework supports middleware, allowing developers to add additional processing logic to requests before they are passed on to the application.

- **Authentication:** The framework includes built-in authentication capabilities, making it easy to authenticate users and protect application routes.


## Requirements
- PHP 8.1
- Composer

## Installation
```bash
git clone https://github.com/prajwal89/php-mvc-framework.git
```

## Start the application

```bash
php artisan start
```

### Documentation


## Routing
all web routes should be registered in routes/web.php

**Examples**
Registering a route:
```php
$app->router->get('/', function () {
    return 'Welcome to the home page!';
});
```

Route that accepts parameters:
```php
$app->router->get('/user/{id}', function ($id) {
    // Retrieve user data based on the provided ID
});
```
Route with view 
```php
$app->router->get('/user/dashboard', 'user.dashboard');
```

Route with a controller method:
```php
$app->router->get('/blog/{slug}', [BlogController::class, 'showBlogPost']);
```

Route with middleware
```php
$app->router->middleware('auth')->get('/user/dashboard', [UserController::class, 'dashboard']);
```

Route that allows multiple HTTP methods:
```php
$app->router->match(['get', 'post'], '/contact', [ContactController::class, 'index']);
```


## Views
All view files should be created in **views/** directory with **.view.php** extension

Render a view
```php
return view('home')->render()
```

Render a view with layout
```php
return view('home')->layout('layouts.app')->render()
```

Pass data to a view\
use with() method in chain to pass more variables 
```php
return view('home')->with('foo',$bar)->render()
```

## Controllers

To create a controller 
```bash
php artisan make:controller UserController
```
this will create a controller ***/controllers/UserController.php***

You can also create controller in subfolder
```bash
php artisan make:controller Admin/UserController
```
this will create a controller ***/controllers/Admin/UserController.php***


## Models
To create a model 
```bash
php artisan make:model User
```
this will create a model ***/models/User.php***

User.php
```php
namespace App\Models;

use App\Core\Abstract\Model;

class User extends Model
{
    // define table name for model 
    protected $table = 'users';

    // fillable column names
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
```

**CRUD** operations
Create
```php
use App\Models\User;

User::create([
   'name' => 'Prajwal',
   'email' => 'Prajwal@mail.com',
   'password' => '$2y$10$PpumfChVOExy2lXWeNWkWO/i4MOFF12VYkE/EY5dxwaKImaWM8jFK',
]);
```

Read
```php
use App\Models\User;

User::find([
   'name' => 'Prajwal',
   'email' => 'Prajwal@mail.com',
]);

// return all records
User::all();
```

Update
```php
use App\Models\User;

User::update($userId,[
   'name' => 'Prajwal hallale',
   'email' => 'Prajwal@mail.com',
]);
```

Delete
```php
use App\Models\User;

User::delete($userId);
```

## Database
Access database directly

```php
use App\Core\Database;

// raw queries
Database::query("DELETE FROM users WHERE id = ?", [123]);

// select
Database::select("SELECT * FROM users WHERE status = ?", [1]);

// update
Database::update("UPDATE users SET name = ? WHERE id = ?", ['John Doe', 123]);

// delete
Database::delete("DELETE FROM users WHERE id = ?", [123]);

// create
Database::create("INSERT INTO users (name, email) VALUES (?, ?)", ['John Doe', 'john@example.com']);
```

## License
This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).