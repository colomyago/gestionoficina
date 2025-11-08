<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use App\Models\Equipment;
use App\Models\User;
use App\Models\Loan;
use App\Models\MaintenanceRequest;
use App\Policies\EquipmentPolicy;
use App\Policies\UserPolicy;
use App\Policies\LoanPolicy;
use App\Policies\MaintenanceRequestPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Equipment::class => EquipmentPolicy::class,
        User::class => UserPolicy::class,
        Loan::class => LoanPolicy::class,
        MaintenanceRequest::class => MaintenanceRequestPolicy::class,
    ];

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
        // Forzar HTTPS en producción (Railway, etc.)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Registrar las políticas
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}

