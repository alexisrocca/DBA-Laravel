<?php

namespace App\Filament\Widgets;

use App\Enums\ReminderMethod;
use App\Models\Event;
use App\Models\Reminder;
use App\Models\Task;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;

class UpcomingReminders extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected function getTableHeading(): ?string
    {
        return '🔔 Próximos Recordatorios';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Reminder::query()
                    ->whereHasMorph(
                        'remindable',
                        [Task::class, Event::class],
                        function ($query) {
                            $query->where('user_id', Auth::id());
                        }
                    )
                    ->where('sent', false)
                    ->where('remind_at', '>=', now())
                    ->where('remind_at', '<=', now()->addDays(7))
                    ->orderBy('remind_at', 'asc')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('remindable_type')
                    ->label('Tipo')
                    ->formatStateUsing(fn ($state) => match (class_basename($state)) {
                        'Task' => '📋 Tarea',
                        'Event' => '📅 Evento',
                        default => class_basename($state),
                    })
                    ->badge()
                    ->color(fn ($state) => match (class_basename($state)) {
                        'Task' => 'info',
                        'Event' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('remindable.title')
                    ->label('Elemento')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('remind_at')
                    ->label('Recordar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->description(fn ($state) => $state->diffForHumans()),

                TextColumn::make('method')
                    ->label('Método')
                    ->badge()
                    ->color(fn (ReminderMethod $state) => match ($state) {
                        ReminderMethod::Push => 'info',
                        ReminderMethod::Email => 'success',
                    }),

                IconColumn::make('sent')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
            ])
            ->recordAction(null)
            ->emptyStateHeading('✅ Sin recordatorios próximos')
            ->emptyStateDescription('No tienes recordatorios programados para los próximos 7 días.')
            ->emptyStateIcon('heroicon-o-bell-slash');
    }
}
