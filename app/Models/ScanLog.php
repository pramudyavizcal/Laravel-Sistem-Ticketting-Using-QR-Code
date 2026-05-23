<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanLog extends Model
{
    protected $fillable = [
        'attendee_id',
        'event_id',
        'result',
        'scanned_by',
        'device_info',
    ];

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getResultLabelAttribute(): string
    {
        return match ($this->result) {
            'success' => '✅ Berhasil',
            'duplicate' => '⚠️ Duplikat',
            'invalid' => '❌ Tidak Valid',
            default => $this->result,
        };
    }
}
