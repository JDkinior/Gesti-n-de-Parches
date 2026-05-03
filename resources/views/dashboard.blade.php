@extends('layouts.bootstrap', ['title' => 'Dashboard'])

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
        <div>
            <h1 class="h2 mb-2 fw-800 text-white">
                <i class="fas fa-chart-line"></i> Panel de Control
            </h1>
            <p class="mb-0" style="color: #f1f5f9;">Visibilidad en tiempo real del estado de sistemas y riesgo de seguridad.</p>
        </div>
        <div class="d-flex gap-2">
            <button id="refreshBtn" class="btn btn-primary" onclick="refreshCharts()" title="Actualizar gráficas">
                <i class="fas fa-sync-alt"></i>
                <span class="spinner-border spinner-border-sm me-2" id="refreshSpinner" style="display:none;\"></span>
                <span class="d-none d-sm-inline">Actualizar</span>
            </button>
            @can('create', App\Models\System::class)
                <a href="{{ route('systems.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i>
                    <span class="d-none d-sm-inline">Nuevo sistema</span>
                </a>
            @endcan
        </div>
    </div>

    <!-- KPIs Row -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-soft" style="border-left: 4px solid #0ea5e9;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-3" style="font-size: 0.875rem; color: rgba(226, 232, 240, 0.7); font-weight: 600;">
                                <i class="fas fa-cube"></i> Total Sistemas
                            </h6>
                            <p class="display-6 fw-800 mb-0" style="color: #f8fafc;">{{ $stats['total_systems'] }}</p>
                        </div>
                        <span class="badge" style="background: rgba(14, 165, 233, 0.2); color: #0ea5e9;">100%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-soft" style="border-left: 4px solid #10b981;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-3" style="font-size: 0.875rem; color: rgba(226, 232, 240, 0.7); font-weight: 600;">
                                <i class="fas fa-clipboard-check"></i> Documentados
                            </h6>
                            <p class="display-6 fw-800 mb-0" style="color: #f8fafc;">{{ $stats['documented_systems'] }}</p>
                        </div>
                        <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #10b981;">{{ $stats['documentation_percentage'] }}%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-soft" style="border-left: 4px solid #f97316;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-3" style="font-size: 0.875rem; color: rgba(226, 232, 240, 0.7); font-weight: 600;">
                                <i class="fas fa-clock"></i> Desactualizados
                            </h6>
                            <p class="display-6 fw-800 mb-0" style="color: #f8fafc;">{{ $stats['outdated_systems'] }}</p>
                        </div>
                        @if($stats['total_systems'] > 0)
                            <span class="badge" style="background: rgba(249, 115, 22, 0.2); color: #f97316;">{{ round(($stats['outdated_systems'] / $stats['total_systems']) * 100) }}%</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card card-soft" style="border-left: 4px solid #ef4444;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-3" style="font-size: 0.875rem; color: rgba(226, 232, 240, 0.7); font-weight: 600;">
                                <i class="fas fa-exclamation-triangle"></i> Riesgo Crítico
                            </h6>
                            <p class="display-6 fw-800 mb-0" style="color: #f8fafc;">{{ $stats['critical_risk_systems'] }}</p>
                        </div>
                        @if($stats['total_systems'] > 0)
                            <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #ef4444;">{{ round(($stats['critical_risk_systems'] / $stats['total_systems']) * 100) }}%</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-lg-6">
            <div class="card card-soft h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: #f1f5f9;">
                        <i class="fas fa-pie-chart"></i> Distribución por Nivel de Riesgo
                    </h5>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="riskChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-soft h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: #f1f5f9;">
                        <i class="fas fa-bar-chart"></i> Estado de Sistemas
                    </h5>
                </div>
                <div class="card-body" style="display: flex; flex-direction: column; gap: 1rem; justify-content: center;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: rgba(51, 65, 85, 0.5); border-radius: 8px; border-left: 4px solid #10b981;">
                        <span style="color: #e2e8f0; font-weight: 600;">Actualizado</span>
                        <span style="color: #10b981; font-size: 2rem; font-weight: bold;" id="status-actualizado">0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: rgba(51, 65, 85, 0.5); border-radius: 8px; border-left: 4px solid #f97316;">
                        <span style="color: #e2e8f0; font-weight: 600;">Desactualizado</span>
                        <span style="color: #f97316; font-size: 2rem; font-weight: bold;" id="status-desactualizado">0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: rgba(51, 65, 85, 0.5); border-radius: 8px; border-left: 4px solid #6b7280;">
                        <span style="color: #e2e8f0; font-weight: 600;">Desconocido</span>
                        <span style="color: #cbd5e1; font-size: 2rem; font-weight: bold;" id="status-desconocido">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Charts -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-lg-6">
            <div class="card card-soft h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: #f1f5f9;">
                        <i class="fas fa-line-chart"></i> Tendencia de Sistemas Críticos (7 días)
                    </h5>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-soft h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: #f1f5f9;">
                        <i class="fas fa-file-check"></i> Porcentaje de Documentación
                    </h5>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="docChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Systems Table -->
    <div class="card card-soft mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0" style="color: #f1f5f9;">
                <i class="fas fa-history"></i> Últimos Sistemas Registrados
            </h5>
            <small style="color: rgba(226, 232, 240, 0.6);">Últimas 5 entradas</small>
        </div>
        <div class="table-responsive" style="background: rgba(30, 41, 59, 0.8); border-radius: 0 0 16px 16px;">
            <table class="table mb-0 align-middle" style="color: #e2e8f0; background: rgba(30, 41, 59, 0.8);">
                <thead style="background: rgba(51, 65, 85, 0.6); border-bottom: 2px solid rgba(226, 232, 240, 0.1);">
                    <tr>
                        <th style="color: #f1f5f9;"><i class="fas fa-box-open"></i> Sistema</th>
                        <th style="color: #f1f5f9;"><i class="fas fa-code-branch"></i> V. Actual</th>
                        <th style="color: #f1f5f9;"><i class="fas fa-arrow-right"></i> V. Objetivo</th>
                        <th style="color: #f1f5f9;"><i class="fas fa-exclamation"></i> Riesgo</th>
                        <th style="color: #f1f5f9;"><i class="fas fa-signal"></i> Estado</th>
                        <th class="text-end" style="color: #f1f5f9;"><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody id="latestSystemsBody">
                    @forelse($latestSystems as $system)
                        <tr style="border-bottom: 1px solid rgba(226, 232, 240, 0.1); transition: background 0.2s;" onmouseover="this.style.background='rgba(51, 65, 85, 0.4)'" onmouseout="this.style.background=''">
                            <td><strong style="color: #f1f5f9;">{{ $system->name }}</strong></td>
                            <td><code style="background: rgba(51, 65, 85, 0.5); color: #0ea5e9; padding: 2px 6px; border-radius: 4px;">{{ $system->current_version }}</code></td>
                            <td><code style="background: rgba(51, 65, 85, 0.5); color: #0ea5e9; padding: 2px 6px; border-radius: 4px;">{{ $system->latest_version }}</code></td>
                            <td><span class="badge" style="background: {{ $system->risk_level === 'critical' ? 'rgba(239, 68, 68, 0.2); color: #ef4444;' : ($system->risk_level === 'high' ? 'rgba(249, 115, 22, 0.2); color: #f97316;' : 'rgba(226, 232, 240, 0.2); color: #cbd5e1;') }}">{{ strtoupper($system->risk_level) }}</span></td>
                            <td><span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #10b981;">{{ ucfirst($system->status) }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('systems.show', $system) }}" class="btn btn-sm btn-primary" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr style="background: rgba(30, 41, 59, 0.8);">
                            <td colspan="6" class="text-center py-4" style="color: rgba(226, 232, 240, 0.6);">
                                <i class="fas fa-inbox"></i> No hay sistemas registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let charts = {};

        function initializeCharts() {
            fetch('{{ route("dashboard.chartData") }}')
                .then(response => response.json())
                .then(data => {
                    createRiskChart(data.riskDistribution);
                    createStatusChart(data.statusDistribution);
                    createTrendChart(data.riskTrend);
                    createDocumentationChart(data.documentationStats);
                })
                .catch(error => console.error('Error loading chart data:', error));
        }

        function refreshCharts() {
            const btn = document.getElementById('refreshBtn');
            const spinner = document.getElementById('refreshSpinner');
            btn.disabled = true;
            spinner.style.display = 'inline-block';

            Object.values(charts).forEach(chart => chart.destroy());
            charts = {};

            setTimeout(() => {
                initializeCharts();
                setTimeout(() => {
                    btn.disabled = false;
                    spinner.style.display = 'none';
                }, 300);
            }, 300);
        }

        function createRiskChart(data) {
            const ctx = document.getElementById('riskChart').getContext('2d');
            charts.risk = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.data,
                        backgroundColor: ['#0ea5e9', '#f97316', '#10b981', '#ef4444'],
                        borderColor: 'rgba(15, 23, 42, 0.8)',
                        borderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 15, font: { size: 12, weight: '600' }, color: '#e2e8f0' }
                        }
                    }
                }
            });
        }

        function createStatusChart(data) {
            const actualizado = document.getElementById('status-actualizado');
            const desactualizado = document.getElementById('status-desactualizado');
            const desconocido = document.getElementById('status-desconocido');
            
            actualizado.textContent = data.data[0] || 0;
            desactualizado.textContent = data.data[1] || 0;
            desconocido.textContent = data.data[2] || 0;
        }

        function createTrendChart(data) {
            const ctx = document.getElementById('trendChart').getContext('2d');
            charts.trend = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Sistemas Críticos',
                        data: data.data,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.15)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#0f172a',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false, labels: { color: '#e2e8f0' } } },
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            ticks: { color: '#e2e8f0' },
                            grid: { color: 'rgba(226, 232, 240, 0.1)' }
                        },
                        x: {
                            ticks: { color: '#e2e8f0' },
                            grid: { color: 'rgba(226, 232, 240, 0.05)' }
                        }
                    }
                }
            });
        }

        function createDocumentationChart(data) {
            const percentage = data.percentage;
            const remaining = 100 - percentage;

            const ctx = document.getElementById('docChart').getContext('2d');
            charts.doc = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Documentados', 'Sin documentar'],
                    datasets: [{
                        data: [percentage, remaining],
                        backgroundColor: ['#0ea5e9', 'rgba(226, 232, 240, 0.2)'],
                        borderColor: 'rgba(15, 23, 42, 0.8)',
                        borderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 15, font: { size: 12, weight: '600' }, color: '#e2e8f0' } },
                        tooltip: { callbacks: { label: (context) => context.label + ': ' + context.parsed + '%' } }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initializeCharts);

        setInterval(() => {
            fetch('{{ route("dashboard.chartData") }}')
                .then(response => response.json())
                .then(data => {
                    if (charts.risk) { charts.risk.data.datasets[0].data = data.riskDistribution.data; charts.risk.update('none'); }
                    createStatusChart(data.statusDistribution);
                    if (charts.trend) { charts.trend.data.datasets[0].data = data.riskTrend.data; charts.trend.update('none'); }
                })
                .catch(error => console.error('Auto-refresh error:', error));
        }, 30000);
    </script>
@endsection
