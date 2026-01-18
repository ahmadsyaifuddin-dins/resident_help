<?php

namespace App\Providers;

use App\Traits\SystemIntegrityTrait;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use SystemIntegrityTrait;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->runningInConsole()) {
            return;
        }
        $this->_verifySystemIntegrity();
    }
}
