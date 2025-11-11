<?php

namespace App\Filament\Resources\Reminders\Tables;

use App\Enums\ReminderMethod;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class RemindersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('remindable_type')
                    ->label('Tipo')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->badge()
                    ->color(fn ($state) => match (class_basename($state)) {
                        'Task' => 'info',
                        'Event' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('remindable.title')
                    ->label('Elemento')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('remind_at')
                    ->label('Recordar en')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->color(fn ($state) => $state && $state->isPast() ? 'warning' : null),

                TextColumn::make('method')
                    ->label('Método')
                    ->badge()
                    ->color(fn (ReminderMethod $state) => match ($state) {
                        ReminderMethod::Push => 'info',
                        ReminderMethod::Email => 'success',
                    }),

                IconColumn::make('sent')
                    ->label('Enviado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('remind_at', 'asc')
            ->filters([
                SelectFilter::make('method')
                    ->options(ReminderMethod::class)
                    ->native(false),

                SelectFilter::make('sent')
                    ->options([
                        '0' => 'Pendiente',
                        '1' => 'Enviado',
                    ])
                    ->native(false),

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
