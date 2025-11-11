<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReminderMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    /** @use HasFactory<\Database\Factories\ReminderFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'remindable_id',
        'remindable_type',
        'remind_at',
        'method',
        'sent',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'remind_at' => 'datetime',
            'method' => ReminderMethod::class,
            'sent' => 'boolean',
        ];
    }

    /**
     * Get the parent remindable model (Task or Event)
     */
    public function remindable(): MorphTo
    {
        return $this->morphTo();
    }
}
