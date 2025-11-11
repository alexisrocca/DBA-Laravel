<?php

namespace App\Filament\Resources\Reminders\Schemas;

use App\Enums\ReminderMethod;
use App\Models\Event;
use App\Models\Task;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReminderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                MorphToSelect::make('remindable')
                    ->label('Recordatorio para')
                    ->types([
                        MorphToSelect\Type::make(Task::class)
                            ->titleAttribute('title'),
                        MorphToSelect\Type::make(Event::class)
                            ->titleAttribute('title'),
                    ])
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),

                DateTimePicker::make('remind_at')
                    ->label('Recordar en')
                    ->required()
                    ->native(false)
                    ->seconds(false),

                Select::make('method')
                    ->label('Método')
                    ->options(ReminderMethod::class)
                    ->default('push')
                    ->required()
                    ->native(false),

                Toggle::make('sent')
                    ->label('Enviado')
                    ->default(false),
            ]);
    }
}
