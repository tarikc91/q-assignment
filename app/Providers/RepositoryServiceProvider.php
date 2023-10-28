<?php

namespace App\Providers;

use App\Repositories\Contracts\BookRepository;
use App\Repositories\Contracts\AuthorRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\QSS\BookRepository as QSSBookRepository;
use App\Repositories\QSS\AuthorRepository as QSSAuthorRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorRepository::class, QSSAuthorRepository::class);
        $this->app->bind(BookRepository::class, QSSBookRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
