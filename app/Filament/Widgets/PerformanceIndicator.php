<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PerformanceIndicator extends Widget
{
    protected static ?int $sort = 1;

    protected string $view = 'filament.widgets.performance-indicator';

    protected int|string|array $columnSpan = 'full';

    public function getPerformanceData(): array
    {
        $userId = Auth::id();
        $thirtyDaysAgo = now()->subDays(30);

        // Total de tareas con fecha de vencimiento en los últimos 30 días
        $totalTasksWithDueDate = Task::where('user_id', $userId)
            ->whereNotNull('due_date')
            ->where('due_date', '>=', $thirtyDaysAgo)
            ->count();

        if ($totalTasksWithDueDate === 0) {
            return [
                'status' => 'neutral',
                'percentage' => 0,
                'message' => 'Sin tareas con vencimiento reciente',
                'color' => 'gray',
                'icon' => '⚪',
                'total' => 0,
                'completed_on_time' => 0,
            ];
        }

        // Tareas completadas a tiempo (antes o en la fecha de vencimiento)
        $completedOnTime = Task::where('user_id', $userId)
            ->whereNotNull('due_date')
            ->whereNotNull('completed_at')
            ->where('due_date', '>=', $thirtyDaysAgo)
            ->whereRaw('completed_at <= due_date')
            ->count();

        $percentage = round(($completedOnTime / $totalTasksWithDueDate) * 100);

        // Determinar el estado del semáforo
        if ($percentage >= 80) {
            $status = 'optimal';
            $message = '¡Excelente! Rendimiento óptimo';
            $color = 'success';
            $icon = '🟢';
        } elseif ($percentage >= 50) {
            $status = 'medium';
            $message = 'Rendimiento aceptable, puedes mejorar';
            $color = 'warning';
            $icon = '🟡';
        } else {
            $status = 'low';
            $message = 'Atención: Rendimiento bajo';
            $color = 'danger';
            $icon = '🔴';
        }

        return [
            'status' => $status,
            'percentage' => $percentage,
            'message' => $message,
            'color' => $color,
            'icon' => $icon,
            'total' => $totalTasksWithDueDate,
            'completed_on_time' => $completedOnTime,
        ];
    }
}
