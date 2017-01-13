<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    protected $defer = true;
   
    public function boot()
    {
        echo 'hello';
    }

    public function register()
    {
        
    }

    public function provides() 
    {
        return [];
    }
}
