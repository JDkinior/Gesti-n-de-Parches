<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = $this->calculateStats();
        $latestSystems = System::query()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'latestSystems'));
    }

    public function chartData(): JsonResponse
    {
        return response()->json([
            'riskDistribution' => $this->getRiskDistribution(),
            'statusDistribution' => $this->getStatusDistribution(),
            'documentationStats' => $this->getDocumentationStats(),
            'recentActivity' => $this->getRecentActivity(),
            'riskTrend' => $this->getRiskTrend(),
        ]);
    }

    private function calculateStats(): array
    {
        return [
            'total_systems' => System::query()->count(),
            'documented_systems' => System::query()->where('is_documented', true)->count(),
            'outdated_systems' => System::query()->where('status', 'outdated')->count(),
            'critical_risk_systems' => System::query()->where('risk_level', 'critical')->count(),
            'documentation_percentage' => $this->getDocumentationPercentage(),
            'average_delay' => $this->getAverageVersionDelay(),
        ];
    }

    private function getRiskDistribution(): array
    {
        $distribution = System::query()
            ->selectRaw('risk_level, COUNT(*) as count')
            ->groupBy('risk_level')
            ->get()
            ->keyBy('risk_level');

        return [
            'labels' => ['Bajo', 'Medio', 'Alto', 'Crítico'],
            'data' => [
                $distribution['low']->count ?? 0,
                $distribution['medium']->count ?? 0,
                $distribution['high']->count ?? 0,
                $distribution['critical']->count ?? 0,
            ],
            'colors' => ['#28a745', '#ffc107', '#fd7e14', '#dc3545'],
        ];
    }

    private function getStatusDistribution(): array
    {
        $distribution = System::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        return [
            'labels' => ['Actualizado', 'Desactualizado', 'Desconocido'],
            'data' => [
                $distribution['updated']->count ?? 0,
                $distribution['outdated']->count ?? 0,
                $distribution['unknown']->count ?? 0,
            ],
        ];
    }

    private function getDocumentationStats(): array
    {
        $total = System::query()->count();
        $documented = System::query()->where('is_documented', true)->count();
        $percentage = $total > 0 ? round(($documented / $total) * 100, 1) : 0;

        return [
            'total' => $total,
            'documented' => $documented,
            'undocumented' => $total - $documented,
            'percentage' => $percentage,
        ];
    }

    private function getRecentActivity(): array
    {
        return System::query()
            ->select('created_at', 'status')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($system) {
                return $system->created_at->format('Y-m-d');
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->toArray();
    }

    private function getRiskTrend(): array
    {
        $lastDays = collect(range(6, 0))
            ->map(function ($days) {
                $date = now()->subDays($days)->format('Y-m-d');
                $count = System::query()
                    ->where('risk_level', 'critical')
                    ->whereDate('created_at', '<=', $date)
                    ->count();
                return $count;
            })
            ->toArray();

        return [
            'labels' => collect(range(6, 0))
                ->map(fn ($days) => now()->subDays($days)->format('d/m'))
                ->toArray(),
            'data' => $lastDays,
        ];
    }

    private function getDocumentationPercentage(): float
    {
        $total = System::query()->count();
        if ($total === 0) return 0;
        return round((System::query()->where('is_documented', true)->count() / $total) * 100, 1);
    }

    private function getAverageVersionDelay(): string
    {
        $average = System::query()
            ->where('last_updated_at', '!=', null)
            ->selectRaw('AVG(DATEDIFF(NOW(), last_updated_at)) as days')
            ->first()?->days ?? 0;

        return round($average) . ' días';
    }
}
