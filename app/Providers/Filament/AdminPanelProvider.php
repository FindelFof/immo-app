<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\ContractsByPropertyTypeChart;
use App\Filament\Widgets\ExpiringContractsWidget;
use App\Filament\Widgets\MonthlyPaymentTrendsChart;
use App\Filament\Widgets\MonthlyRentalIncomeChart;
use App\Filament\Widgets\NeighborhoodPriceChart;
use App\Filament\Widgets\PaymentCalendarWidget;
use App\Filament\Widgets\PaymentMethodDistributionChart;
use App\Filament\Widgets\PendingPaymentsWidget;
use App\Filament\Widgets\PropertyDistributionChart;
use App\Filament\Widgets\PropertyTypeMetrics;
use App\Filament\Widgets\RentalContractStats;
use App\Filament\Widgets\RentPaymentStats;
use App\Filament\Widgets\UserStatsWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\RentalContractResource;
use App\Filament\Resources\RentPaymentResource;
use App\Filament\Resources\PropertyRequestResource;
use App\Filament\Resources\SaleContractResource;
use App\Filament\Resources\PropertyVisitResource;
use App\Filament\Resources\PropertyFavoriteResource;
use App\Filament\Resources\PropertyAlertResource;
use App\Filament\Resources\PropertyImageResource;
use App\Filament\Widgets\PropertyStatsOverview;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()
            ->profile()
            ->colors([
                'primary' => Color::Amber,
                'gray' => Color::Slate,
                'danger' => Color::Rose,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->font('Poppins')
            ->brandName('GFI-CO Immo')
            ->favicon(asset('images/favicon.png'))
            ->sidebarFullyCollapsibleOnDesktop()
            ->navigationGroups([
               /* 'Gestion des biens',
                'Gestion des contrats',
                'Gestion des utilisateurs',
                'Demandes et visites',
                'Paramètres',*/
            ])
            ->resources([
                PropertyResource::class,
                RentalContractResource::class,
                RentPaymentResource::class,
                UserResource::class,
                /* PropertyImageResource::class,
                SaleContractResource::class,
                RentPaymentResource::class,
                PropertyRequestResource::class,
                PropertyVisitResource::class,
                PropertyFavoriteResource::class,
                PropertyAlertResource::class,*/
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                // Premiers widgets sans modification
                //Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
                UserStatsWidget::class,
                PropertyStatsOverview::class,
                RentalContractStats::class,
                RentPaymentStats::class,

                // Widgets en 2 par ligne (première paire)
               PropertyDistributionChart::class, // Sort: 10
                PropertyTypeMetrics::class,       // Sort: 11

                // Deuxième paire
                NeighborhoodPriceChart::class,    // Sort: 12
                ExpiringContractsWidget::class,   // Sort: 13

                // Troisième paire
                ContractsByPropertyTypeChart::class, // Sort: 14
                MonthlyRentalIncomeChart::class,     // Sort: 15

                // Quatrième paire
                PendingPaymentsWidget::class,     // Sort: 16
                MonthlyPaymentTrendsChart::class, // Sort: 17

                //Cinquième paire
                PaymentMethodDistributionChart::class, // Sort: 18
                PaymentCalendarWidget::class,          // Sort: 19
                // Vous pouvez ajouter un autre widget ici avec Sort: 17 pour compléter la paire
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
            ])
            ->databaseNotifications();
           /* ->renderHook(
                'panels::body.end',
                fn () => view('filament.custom.footer'),
            );*/
    }
}
