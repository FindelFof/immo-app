<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Property;
use App\Models\RentalContract;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '160s';

    protected int | string | array $columnSpan = 6;

    protected function getStats(): array
    {
        // Compter les utilisateurs par rôle
        $roleStats = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->role => $item->count];
            });

        // Obtenir le nombre total d'utilisateurs
        $totalUsers = User::count();

        // Nouveaux utilisateurs ce mois-ci
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Ratio propriétaires/locataires
        $ownerCount = $roleStats['owner'] ?? 0;
        $tenantCount = $roleStats['tenant'] ?? 0;
        $tenantToOwnerRatio = $ownerCount > 0 ? round($tenantCount / $ownerCount, 1) : 0;

        // Récupérer les tendances sur 6 mois
        $userTrend = $this->getUserTrend(6);

        return [
            Stat::make('Total des utilisateurs', $totalUsers)
                ->description('Tous utilisateurs confondus')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart($userTrend),

            Stat::make('Propriétaires', $ownerCount)
                ->description('Possèdent des biens')
                ->descriptionIcon('heroicon-m-home')
                ->color('success')
                ->chart($this->getRoleTrend('owner', 6)),

            Stat::make('Locataires', $tenantCount)
                ->description('Louent des biens')
                ->descriptionIcon('heroicon-m-key')
                ->color('warning')
                ->chart($this->getRoleTrend('tenant', 6)),

            Stat::make('Clients', $roleStats['client'] ?? 0)
                ->description('Prospects')
                ->descriptionIcon('heroicon-m-user')
                ->color('gray')
                ->chart($this->getRoleTrend('client', 6)),

            Stat::make('Nouveaux ce mois', $newUsersThisMonth)
                ->description('Utilisateurs créés en ' . now()->format('F'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info')
                ->chart($this->getNewUsersTrend(6)),

            Stat::make('Ratio locataires/propriétaires', $tenantToOwnerRatio)
                ->description($tenantCount . ' locataires pour ' . $ownerCount . ' propriétaires')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('danger')
                ->chart($this->getTenantOwnerRatioTrend(6)),
        ];
    }

    /**
     * Obtenir la tendance des utilisateurs sur une période donnée
     */
    protected function getUserTrend($months): array
    {
        $trend = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::whereDate('created_at', '<=', $date)->count();
            $trend[] = $count;
        }

        return $trend;
    }

    /**
     * Obtenir la tendance des utilisateurs d'un rôle spécifique
     */
    protected function getRoleTrend($role, $months): array
    {
        $trend = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::where('role', $role)
                ->whereDate('created_at', '<=', $date)
                ->count();
            $trend[] = $count;
        }

        return $trend;
    }

    /**
     * Obtenir la tendance des nouveaux utilisateurs par mois
     */
    protected function getNewUsersTrend($months): array
    {
        $trend = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $trend[] = $count;
        }

        return $trend;
    }

    /**
     * Obtenir la tendance du ratio locataires/propriétaires
     */
    protected function getTenantOwnerRatioTrend($months): array
    {
        $trend = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $ownerCount = User::where('role', 'owner')
                ->whereDate('created_at', '<=', $date)
                ->count();

            $tenantCount = User::where('role', 'tenant')
                ->whereDate('created_at', '<=', $date)
                ->count();

            $ratio = $ownerCount > 0 ? round($tenantCount / $ownerCount, 1) : 0;
            $trend[] = $ratio;
        }

        return $trend;
    }
}
