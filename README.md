<p align="center"><img src="http://dev.lucasbustamante.com.br/mww-logo.svg"></p>

## About Modern WordPress Website

Modern WordPress Website (MWW) is a modern way of building WordPress websites. Simple and powerful, it's a great skeleton to bootstrap a new WordPress project.

## Think of it as a functions.php with an OOP architecture similar to Laravel.

First, you route WordPress conditional tags such as *is_front_page()* to Controllers, then you fetch/manipulate data and render a view with the data. With MWW, you don't use a theme. However, like in functions.php, you have access to all WordPress functions and plugins.

- MVC in WordPress.
- Modern, yet simple PHP.
- PSR-4 Autoloading.
- Dependency Injection Container (Thanks Luca Tume, for [di52](https://github.com/lucatume/di52))
- Acceptance, Functional, Integration and Unit tests (Thanks Luca Tume, for [wp-browser](https://github.com/lucatume/wp-browser))
- Installs as a *mu-plugin*
- MWW is in BETA state.

Modern WordPress Website (MWW) is great for experienced PHP developers using WordPress, and for intermediate developers who want to take their skills to the next level.

MWW is in beta and open to contributors. Help us test and develop it!

## Building a Small Project

[![Click to watch on YouTube](https://img.youtube.com/vi/avEukD0meAg/0.jpg)](https://www.youtube.com/watch?v=avEukD0meAg)

[(Click to watch on YouTube)](https://www.youtube.com/watch?v=avEukD0meAg)

## Installation

*Modern WordPress Website* is installed as a mu-plugin. This way we intercept WordPress requests at an earlier stage and have more control over the application.

To get started, simply follow these steps in a clean WordPress installation:

- Run `git clone https://github.com/Luc45/ModernWordPressWebsite wp-content/mu-plugins` in the root folder of a clean WordPress installation
- Run `composer update` in **wp-content/mu-plugins/mww/**
- (Recommended) You will not need your theme anymore, you can create an empty theme with just index.php, style.css and functions.php. [Download empty theme](https://github.com/Luc45/EmptyTheme/archive/master.zip).
- (Recommended) Set up tests by editing .env.example and renaming it to .env - Run tests with `vendor/bin/codecept run`

Now it's up to you to create awesome stuff!

## How it works

Even though MWW is powerful, it's also very simple. It all starts with the routes:

```php
// routes/app.php
use App/Controller/Pages/Home_Controller;

Route::add( 'is_front_page', [ Home_Controller::class, 'index' ] );
```

If `is_front_page()` is true, then call the method `index()` of `App/Controller/Pages/Home_Controller`:

```php
// app/Controller/Pages/Home_Controller.php
namespace App/Controller/Pages;

class Home_Controller extends Controller {

    public function index() {
        $this->render('pages.home');
    }
    
}
```

Now all you need is a view!

```php
// views/pages/home.blade.php
@extends('layouts.main')

@section('content')
    I am the homepage!
@endsection

```

That's all we need to get started!

MWW follows the Convention-over-Configuration (CoC) philosophy, which aims to make your code cleaner and smarter if you want to use the sensible defaults it provides. For instance, on the example above, you could also register your route like this: `Route::add( 'is_front_page', Home_Controller::class );`

If you pass just a class name to a Route, it will try to call `index()` on it by default.

Of course that modern applications uses a lot of dynamic data, not only static views. Here's how we can show Posts on the Home page:

```php
class Home_Controller extends Controller {

    public function index() {
        $this->render( 'pages.home', [
            'posts' => get_posts()
        ] );
    }
    
}
```
Then, we have a variable `$posts` in our home view with the content of `get_posts()`:
```php
// views/pages/home.blade.php
<?php foreach ( $posts as $post ): ?>
    <a href="<?= esc_url( get_the_permalink($post->ID) ) ?>"><?= esc_html( $post->post_title ) ?></a>
<?php endforeach; ?>
<?php if (empty($posts)): ?>
   No posts to show
<?php endif; ?>
```

Since this is a [Blade](https://laravel.com/docs/blade) template, this would also work:

```php
// views/pages/home.blade.php
@forelse ( $posts as $post )
    <a href=" {{ esc_url( get_the_permalink($post->ID) ) }} ">{{ esc_html($post->post_title) }}</a>
@empty
    No posts to show
@endforelse
```

What if we want to show a Single post, now?

Well, it's easy as 123:

```php
// 1: Register the route
Route::add( 'is_single', Post_Controller::class );

// 2: Create the Controller
class Post_Controller extends Controller {
    public function index() {
        $this->render('pages.post');
    }
}

// 3: Create the View. You don't need to pass the post to it
//    because WordPress globals are always available in the views.
//    You can even use the special @loop directive to loop through
//    the current query, similar to while (has_post()): the_post();
//    in a regular WordPress context.
@extends('layouts.main')

@section('content')
    @loop
        <h1 class="post-title">
            {!! esc_html(get_the_title()) !!}
        </h1>
    @endloop
@endsection
```


You see? This is MVC. We could easily separate the logic - we don't need to use `get_posts()` in our view, we can do it in the Controller, or better yet, ask a Model to fetch and prepare that data, and then we pass it to the view. This way, it is easier for our application to grow organized.

## Contributing

Contributions are welcome. Feel free to open an issue or a Pull-Request! MMW follows most of the WordPress Code style.

## To-dos

- Throw custom Exceptions throughout the framework and app
- Implement Service Providers
- Write more tests

## License

The Modern WordPress Website is licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Jetbrains

Thanks to [Jetbrains](https://www.jetbrains.com) for providing a free license for their excellent PHPStorm IDE.  
<a href="https://www.jetbrains.com">
  <img src="https://upload.wikimedia.org/wikipedia/commons/1/1a/JetBrains_Logo_2016.svg" alt="Jetbrains">
</a>
