# PHP_Laravel12_Drafts


A Laravel 12 demo project that implements draft and publish functionality for posts using the Laravel Drafts package.


## Project Description

PHP_Laravel12_Drafts is a simple Laravel 12 web application that demonstrates how to implement a draft and publish system for posts using the Laravel Drafts package.

The application allows users to create posts, save them as drafts, and publish them when ready. This helps simulate how content management systems manage draft versions and published versions of content.

The project is designed for learning purposes to understand how Laravel models, controllers, migrations, and views work together with a third-party package.


## Features

- Create new posts with title and content

- Save posts as Draft without publishing them

- Publish posts directly from the form

- Display posts with Draft or Published status

- Simple and clean user interface using Blade templates and CSS

- Uses Laravel Drafts package to manage draft records


## Technologies Used

- PHP
- Laravel 12
- MySQL
- Blade Template Engine
- HTML
- CSS
- Composer



## System Requirements

Before running the project, make sure the following tools are installed:

- PHP 8.2 or higher

- Composer

- MySQL / MariaDB

- XAMPP / Laragon / Local server

- Laravel 12.x


## Learning Objectives

This project helps developers understand:

- Laravel MVC architecture
- Database migrations and schema design
- Using third-party Laravel packages
- Implementing draft and publish functionality
- Creating simple CRUD-style applications in Laravel



---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Drafts "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Drafts

```

#### Explanation:

This command installs a fresh Laravel 12 application using Composer and creates a new project folder named PHP_Laravel12_Drafts.

The cd command moves into the project directory so you can start working on the application.




## STEP 2: Database Setup 

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_Drafts
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_Drafts

```

### Then Run:

```
php artisan migrate

```


#### Explanation:

This step connects the Laravel application to the MySQL database by updating the .env configuration file.

Running php artisan migrate creates the default Laravel database tables.





## STEP 3: Install Laravel Drafts Package

### Install package:

```
composer require oddvalue/laravel-drafts

```

### Publish configuration

```
php artisan vendor:publish --tag="drafts-config"

```

### Now config file will be created

```
config/drafts.php

```

### Default configuration example:

```
return [

    'revisions' => [
        'keep' => 10,
    ],

    'column_names' => [
        'is_current' => 'is_current',
        'is_published' => 'is_published',
        'published_at' => 'published_at',
        'uuid' => 'uuid',
        'publisher_morph_name' => 'publisher',
    ],

    'auth' => [
        'guard' => 'web',
    ],
];

```

#### Explanation:

This command installs the Laravel Drafts package, which allows models to support draft and published versions of records.

Publishing the configuration file creates config/drafts.php, where package settings can be customized.






## STEP 4: Create Model and Migration

### Create Post model

```
php artisan make:model Post -mcr

```

### This creates

```
app/Models/Post.php
database/migrations/create_posts_table.php
app/Http/Controllers/PostController.php

```

#### Explanation:

This command creates a Post model, a database migration, and a PostController automatically.

These files help manage post data, database structure, and application logic.





## STEP 5: Migration Setup

### Open migration: database/migrations/create_posts_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->text('content')->nullable();

            $table->drafts();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

```


### Then Run:

```
php artisan migrate

```

#### Explanation:

In this step, we define the posts table structure including title, content, and draft-related columns.

The $table->drafts() method adds columns required by the Laravel Drafts package to manage drafts and published records.





## STEP 6: Setup Model

### Open: app/Models/Post.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Oddvalue\LaravelDrafts\Concerns\HasDrafts;

class Post extends Model
{
    use HasDrafts;

    protected $fillable = [
        'title',
        'content',
        'is_published'
    ];
}

```

#### Explanation:

The Post model uses the HasDrafts trait, which enables draft functionality for the model.

The $fillable property allows safe mass assignment of the title, content, and publish status.






## STEP 7: Setup Controller

### Open: app/Http/Controllers/PostController.php

```
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::withDrafts()->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required'
        ]);

        if ($request->status == "draft") {

            Post::createDraft([
                'title' => $request->title,
                'content' => $request->content
            ]);

        } else {

            Post::create([
                'title' => $request->title,
                'content' => $request->content
            ]);

        }

        return redirect()->route('posts.index');
    }

}

```

#### Explanation:

The controller handles the application logic for displaying posts, creating new posts, and saving them as draft or published.

It checks the form status and stores the post accordingly.




## STEP 8: Routes

### Open: routes/web.php

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class,'index'])->name('posts.index');

Route::get('/create',[PostController::class,'create']);

Route::post('/store',[PostController::class,'store'])->name('posts.store');

```

#### Explanation:

Routes define the URLs of the application and map them to controller methods.

These routes allow users to view posts, open the create page, and store new posts.






## STEP 9: Create Views

### Create folder

```
resources/views/posts

```

### resources/views/posts/index.blade.php

```
<!DOCTYPE html>
<html>

<head>
    <title>Post List</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f1f1f1;
        }

        .status-published {
            color: green;
            font-weight: bold;
        }

        .status-draft {
            color: orange;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Post List</h1>

        <a href="/create" class="btn">Create Post</a>

        <table>

            <tr>
                <th>Title</th>
                <th>Status</th>
            </tr>

            @foreach($posts as $post)

                <tr>

                    <td>{{ $post->title }}</td>

                    <td>

                        @if($post->is_published)

                            <span class="status-published">
                                Published
                            </span>

                        @else

                            <span class="status-draft">
                                Draft
                            </span>

                        @endif

                    </td>

                </tr>

            @endforeach

        </table>

    </div>

</body>

</html>

```


### resources/views/posts/create.blade.php

```
<!DOCTYPE html>
<html>

<head>

    <title>Create Post</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        .container {
            width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 120px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .publish {
            background: #28a745;
            color: white;
        }

        .draft {
            background: #ffc107;
            color: black;
        }

        .back {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            color: #3490dc;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Create Post</h1>

        <a href="/" class="back">← Back to Posts</a>

        <form action="{{ route('posts.store') }}" method="POST">

            @csrf

            <label>Title</label>

            <input type="text" name="title" required>

            <label>Content</label>

            <textarea name="content"></textarea>

            <button type="submit" name="status" value="publish" class="btn publish">
                Publish
            </button>

            <button type="submit" name="status" value="draft" class="btn draft">
                Save Draft
            </button>

        </form>

    </div>

</body>

</html>

```

#### Explanation:

Views are used to create the user interface of the application using Blade templates.

The index page displays all posts, and the create page provides a form to add new posts.





 ## STEP 10: Test It

### Start Laravel dev server:

```
php artisan serve

```

### Open in browser:

```
http://127.0.0.1:8000

```

#### Explanation:

Running php artisan serve starts the Laravel development server.

Opening the given URL in the browser allows you to test the draft and publish functionality of the application.





## Expected Output:

### Post List Page:


<img width="1916" height="940" alt="Screenshot 2026-03-12 125700" src="https://github.com/user-attachments/assets/a4a9dfa3-f7ea-4ba6-96bb-122edb2ba088" />


### Create Post Page:


<img width="1919" height="913" alt="Screenshot 2026-03-12 125724" src="https://github.com/user-attachments/assets/5963586b-e425-4ede-8ebe-c465487884d7" />


### Draft Post Status:


<img width="1918" height="944" alt="Screenshot 2026-03-12 125734" src="https://github.com/user-attachments/assets/f7b95793-7a5d-4b07-9bc0-029e19ce07a3" />


### Publish Post:


<img width="1919" height="930" alt="Screenshot 2026-03-12 125802" src="https://github.com/user-attachments/assets/fe445499-3162-4449-ab4b-1a3e1fe4bf10" />


### Published Post Status:


<img width="1919" height="909" alt="Screenshot 2026-03-12 125809" src="https://github.com/user-attachments/assets/9b979939-e259-4db2-aa00-196d69a413d6" />




---

# Project Folder Structure:

```
PHP_Laravel12_Drafts
│
├── app
│   │
│   ├── Http
│   │   └── Controllers
│   │       └── PostController.php
│   │
│   └── Models
│       └── Post.php
│
├── bootstrap
│
├── config
│   ├── app.php
│   ├── database.php
│   └── drafts.php
│
├── database
│   │
│   ├── migrations
│   │   └── xxxx_xx_xx_create_posts_table.php
│   │
│   └── seeders
│
├── public
│   └── index.php
│
├── resources
│   │
│   ├── views
│   │   └── posts
│   │       ├── index.blade.php
│   │       └── create.blade.php
│   │
│   ├── css
│   └── js
│
├── routes
│   └── web.php
│
├── storage
│
├── tests
│
├── .env
├── artisan
├── composer.json
└── README.md

```
