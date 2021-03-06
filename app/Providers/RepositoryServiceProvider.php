<?php

namespace App\Providers;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\Eloquent\ArticleRepository;
use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\Eloquent\Base\EloquentRepositoryInterface;
use App\Repositories\Eloquent\TagRepository;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Support\ServiceProvider;


/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }

}
