<?php

namespace App\Filament\Resources\Reminders\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReminderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('remindable_type'),
                TextEntry::make('remindable_id')
                    ->numeric(),
                TextEntry::make('remind_at')
                    ->dateTime(),
                TextEntry::make('method')
                    ->badge(),
                IconEntry::make('sent')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
