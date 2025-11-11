<?php

declare(strict_types=1);

namespace App\Enums;

enum ReminderMethod: string
{
    case Push = 'push';
    case Email = 'email';
}
