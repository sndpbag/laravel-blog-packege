<?php

namespace Sndpbag\Blog\Providers;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'blog'); // 'blog' নামটি গুরুত্বপূর্ণ

        $this->publishes([
            __DIR__.'/../../config/blog.php' => config_path('blog.php'),
        ], 'blog-config');

        $this->publishes([
            __DIR__.'/../../resources/assets' => public_path('vendor/blog'),
        ], 'blog-assets');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/blog.php', 'blog'
        );
    }
}