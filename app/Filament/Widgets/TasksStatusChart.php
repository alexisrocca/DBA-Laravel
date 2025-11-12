<?php

namespace App\Filament\Widgets;

use App\Enums\TaskStatus;
use App\Models\Task;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class TasksStatusChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = '🥧 Distribución de Tareas por Estado';

    protected ?string $description = 'Vista general del estado de todas tus tareas';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $userId = Auth::id();

        // Obtener conteo por cada estado
        $pending = Task::where('user_id', $userId)
            ->where('status', TaskStatus::Pending)
            ->count();

        $inProgress = Task::where('user_id', $userId)
            ->where('status', TaskStatus::InProgress)
            ->count();

        $completed = Task::where('user_id', $userId)
            ->where('status', TaskStatus::Completed)
            ->count();

        $cancelled = Task::where('user_id', $userId)
            ->where('status', TaskStatus::Cancelled)
            ->count();

        $total = $pending + $inProgress + $completed + $cancelled;

        return [
            'datasets' => [
                [
                    'label' => 'Tareas',
                    'data' => [$pending, $inProgress, $completed, $cancelled],
                    'backgroundColor' => [
                        'rgb(251, 191, 36)', // Amarillo (Pending)
                        'rgb(59, 130, 246)', // Azul (In Progress)
                        'rgb(34, 197, 94)', // Verde (Completed)
                        'rgb(239, 68, 68)', // Rojo (Cancelled)
                    ],
                    'borderColor' => [
                        'rgb(251, 191, 36)',
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(239, 68, 68)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                "Pendientes ({$pending})",
                "En Progreso ({$inProgress})",
                "Completadas ({$completed})",
                "Canceladas ({$cancelled})",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'maintainAspectRatio' => true,
            'responsive' => true,
        ];
    }
}
