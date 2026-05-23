<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'venue',
        'event_date',
        'event_time',
        'quota',
        'organizer',
        'logo_path',
        'banner_path',
        'theme_color',
        'is_active',
        'is_paid',
        'price',
        'payment_bank_name',
        'payment_bank_number',
        'payment_bank_holder',
        'allow_manual_transfer',
        'allow_xendit',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
        'is_paid' => 'boolean',
        'price' => 'decimal:2',
        'allow_manual_transfer' => 'boolean',
        'allow_xendit' => 'boolean',
    ];

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        if (! $user || $user->isSuperAdmin()) {
            return $query;
        }

        return $query->where('created_by', $user->id);
    }

    public function scanLogs(): HasMany
    {
        return $this->hasMany(ScanLog::class);
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'wisuda' => '🎓',
            'seminar' => '📚',
            'konser' => '🎵',
            'workshop' => '🔧',
            default => '🎟️',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'wisuda' => 'Wisuda',
            'seminar' => 'Seminar',
            'konser' => 'Konser',
            'workshop' => 'Workshop',
            default => ucfirst($this->type),
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'wisuda' => '#6C63FF',
            'seminar' => '#00C9FF',
            'konser' => '#FF6B6B',
            'workshop' => '#43E97B',
            default => '#6C63FF',
        };
    }

    public function getCheckedInCountAttribute(): int
    {
        return $this->attendees()->where('is_checked_in', true)->count();
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->event_date ? \Carbon\Carbon::parse($this->event_date)->translatedFormat('d F Y') : '-';
    }

    public function getSisaKuotaAttribute(): int
    {
        return max(0, $this->quota - $this->attendees()->count());
    }
}
