<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->description)
                    ->limit(50),

                TextColumn::make('project.name')
                    ->badge()
                    ->color(fn ($record) => $record->project?->color)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (TaskStatus $state) => match ($state) {
                        TaskStatus::Pending => 'warning',
                        TaskStatus::Completed => 'success',
                    }),

                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (TaskPriority $state) => match ($state) {
                        TaskPriority::Low => 'gray',
                        TaskPriority::Medium => 'info',
                        TaskPriority::High => 'danger',
                    }),

                TextColumn::make('due_date')
                    ->label('Vencimiento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->color(fn ($state) => $state && $state->isPast() ? 'danger' : null),

                TextColumn::make('completed_at')
                    ->label('Completada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('due_date', 'asc')
            ->filters([
                SelectFilter::make('status')
                    ->options(TaskStatus::class)
                    ->native(false),

                SelectFilter::make('priority')
                    ->options(TaskPriority::class)
                    ->native(false),

                SelectFilter::make('project')
                    ->relationship('project', 'name')
                    ->searchable()
                    ->preload(),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
