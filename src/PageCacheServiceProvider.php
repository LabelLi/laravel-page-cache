<?php
/**
 * [Function Description]
 *
 * Class PageCacheServiceProvider
 * @package LabelLi\Pagecache
 * @version 0.1.0
 * @author Label label@lmw.hk
 * @date 2021-08-15
 * @since 0.1.0 2021-08-15 Label: Implemented
 */


namespace LabelLi\LaravelPageCache;


use Illuminate\Support\ServiceProvider;
use LabelLi\LaravelPageCache\Console\ClearCache;

class PageCacheServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(ClearCache::class);

        $this->app->singleton(Cache::class);
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/pagecache.php' => config_path('pagecache.php'),
        ]);
    }
}
