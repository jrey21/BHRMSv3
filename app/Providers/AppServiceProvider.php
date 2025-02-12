<?php

namespace App\Providers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::created(function ($model) {
            Log::info('🚀 CREATED event triggered for model: ' . get_class($model));
        });
    
        Model::updated(function ($model) {
            Log::info('🛠 UPDATED event triggered for model: ' . get_class($model));
        });
    
        Model::deleted(function ($model) {
            Log::info('🔥 DELETED event triggered for model: ' . get_class($model));
        });
        
    }
}
