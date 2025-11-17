<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                    'primary' => [
                    50 => '#004aad',
                    100 => '#004aad',
                    200 => '#004aad',
                    300 => '#004aad',
                    400 => '#004aad',
                    500 => '#004aad',
                    600 => '#004aad',
                    700 => '#004aad',
                    800 => '#004aad',
                    900 => '#004aad',
                    950 => '#004aad',
                ],
                'purple' => [
                    50  => '#faf5ff',
                    100 => '#f3e8ff',
                    200 => '#e9d5ff',
                    300 => '#d8b4fe',
                    400 => '#c084fc',
                    500 => '#a855f7',
                    600 => '#9333ea',
                    700 => '#7e22ce',
                    800 => '#6b21a8',
                    900 => '#581c87',
                    950 => '#3b0764',
                ],
            ])
            ->brandLogo(asset('images/logo.svg'))
            ->brandLogoHeight("7rem")
            ->favicon(asset('images/favico.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverviewWidget::class,
                \App\Filament\Widgets\EquipmentChartWidget::class,
                \App\Filament\Widgets\RecentLoansWidget::class,
                \App\Filament\Widgets\MyActiveLoansWidget::class,
                \App\Filament\Widgets\PendingMaintenanceWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
