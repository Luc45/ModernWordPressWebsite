<p align="center"><img src="http://dev.lucasbustamante.com.br/mww-logo.svg"></p>

## Modern WordPress Website (MWW)

Modern WordPress Website (MWW) is a disruptive way of building a WordPress website.

It couples with WordPress as a `mu-plugin` to provide a rich OOP environment to build a clean and solid application. 

### Highlights

- Modern PHP
- PSR-4
- Blade Templates
- Service Providers
- DI Container ([di52](https://github.com/lucatume/di52))
- Automated tests ([wp-browser](https://github.com/lucatume/wp-browser))

## Building a Small Project

[![Click to watch on YouTube](https://img.youtube.com/vi/avEukD0meAg/0.jpg)](https://www.youtube.com/watch?v=avEukD0meAg)

[(Click to watch on YouTube)](https://www.youtube.com/watch?v=avEukD0meAg)

## Installation

MWW is installed as a mu-plugin. This way we intercept WordPress requests at the earliest stage possible and have more control over the application.

To get started in a fresh copy of WordPress:

1. On the root folder, run: `git clone https://github.com/Luc45/ModernWordPressWebsite wp-content/mu-plugins`
2. Go to `wp-content/mu-plugins/mww/` and run `composer update` 
3. (Recommended) Rename `.env.example` to `.env` and enter your environment credentials in it. Run a test with `vendor/bin/codecept run <suite>`. The available suites by default are `wpunit`, `acceptance`, `functional` and `unit`.
4. (Recommended) Delete all themes from `wp-content/themes` and activate [Empty Theme](https://github.com/Luc45/EmptyTheme/archive/master.zip) as your theme.

## How MWW works

MWW leverages the `template_include` filter to implement it's own `Template` system and keep all the application logic inside MWW itself, thus not needing a theme.

We start by routing requests to the appropriate views.

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

Now all you need is a view:

```php
// views/pages/home.blade.php
@extends('layouts.main')

@section('content')
    I am the homepage!
@endsection

```

That's all we need to get started.

MWW follows the Convention-over-Configuration (CoC) philosophy, which aims to make your code cleaner and smarter if you want to use the sensible defaults it provides. For instance, on the example above, you could also ommit the `'index'` parameter of the route: `Route::add( 'is_front_page', Home_Controller::class );`

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
<?php endforeach; if (empty($posts)): ?>
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
//    since WordPress globals are always available in the views.
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


That's all you need to get started.

MWW has already proven to be viable on averagely complex projects. It is, however, in beta state and open to contributors. Help us test and develop it! 

## Contributing

Contributions are very welcome. Please raise an issue or open a pull-request. When submitting a PR, please follow the WordPress coding standards.

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
