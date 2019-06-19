<?php

namespace App\Providers;

use App\Contract\GitService;
use App\Http\Controllers\GitServiceController;
use Illuminate\Support\ServiceProvider;

class GitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
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
        $this->app->bind(GitService::class, function(){
            return new GitServiceController();
        });
    }
}
