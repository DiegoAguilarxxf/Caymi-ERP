<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

use App\Models\Order;
use App\Models\OperationalLog;
use App\Models\SemanticSearchLog;
use App\Models\ChatbotLog;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * RELACIONES
     */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function managedOrders()
    {
        return $this->hasMany(Order::class, 'admin_id');
    }

    public function operationalLogs()
    {
        return $this->hasMany(OperationalLog::class);
    }

    public function semanticSearchLogs()
    {
        return $this->hasMany(SemanticSearchLog::class);
    }

    public function chatbotLogs()
    {
        return $this->hasMany(ChatbotLog::class);
    }

    /**
     * CASTS
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}