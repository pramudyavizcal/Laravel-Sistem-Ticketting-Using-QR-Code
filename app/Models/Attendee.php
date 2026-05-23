<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendee extends Model
{
    protected $fillable = [
        'event_id',
        'ticket_code',
        'name',
        'email',
        'phone',
        'seat_number',
        'ticket_type',
        'institution',
        'faculty',
        'major',
        'is_checked_in',
        'checked_in_at',
        'checked_in_by',
        'registration_status',
        'payment_status',
        'payment_method',
        'payment_proof_path',
        'admin_note',
        'notes',
    ];

    protected $casts = [
        'is_checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function scanLogs(): HasMany
    {
        return $this->hasMany(ScanLog::class);
    }

    public function getTicketUrlAttribute(): string
    {
        return route('ticket.show', $this->ticket_code);
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->is_checked_in
            ? '<span class="badge badge-success">✅ Sudah Check-in</span>'
            : '<span class="badge badge-warning">⏳ Belum Check-in</span>';
    }
}
