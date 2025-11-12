@php
    $data = $this->getPerformanceData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-4">
            <!-- Título -->
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">🚦 Indicador de Rendimiento</h3>
                <span class="text-sm text-gray-500 dark:text-gray-400">Últimos 30 días</span>
            </div>

            <!-- Semáforo Principal -->
            <div class="flex items-center justify-center p-6 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div class="text-center">
                    <div class="text-6xl mb-2">{{ $data['icon'] }}</div>
                    <div class="text-3xl font-bold mb-2 @if($data['color'] === 'success') text-green-600 dark:text-green-400 @elseif($data['color'] === 'warning') text-yellow-600 dark:text-yellow-400 @elseif($data['color'] === 'danger') text-red-600 dark:text-red-400 @else text-gray-600 dark:text-gray-400 @endif">
                        {{ $data['percentage'] }}%
                    </div>
                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $data['message'] }}
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        {{ $data['completed_on_time'] }} de {{ $data['total'] }} tareas completadas a tiempo
                    </div>
                </div>
            </div>

            <!-- Leyenda del Semáforo -->
            <div class="border-t pt-4 dark:border-gray-700">
                <h4 class="text-sm font-semibold mb-3 text-gray-700 dark:text-gray-300">📖 Leyenda del Semáforo:</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <!-- Verde -->
                    <div class="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="text-2xl">🟢</div>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-green-700 dark:text-green-400">Óptimo</div>
                            <div class="text-xs text-green-600 dark:text-green-500">≥ 80% a tiempo</div>
                        </div>
                    </div>

                    <!-- Amarillo -->
                    <div class="flex items-center gap-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                        <div class="text-2xl">🟡</div>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-yellow-700 dark:text-yellow-400">Aceptable</div>
                            <div class="text-xs text-yellow-600 dark:text-yellow-500">50% - 79% a tiempo</div>
                        </div>
                    </div>

                    <!-- Rojo -->
                    <div class="flex items-center gap-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                        <div class="text-2xl">🔴</div>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-red-700 dark:text-red-400">Bajo</div>
                            <div class="text-xs text-red-600 dark:text-red-500">< 50% a tiempo</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="text-xs text-gray-500 dark:text-gray-400 text-center italic">
                * El rendimiento se calcula en base a tareas completadas antes o en su fecha de vencimiento
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
