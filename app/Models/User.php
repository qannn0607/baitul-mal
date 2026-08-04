<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'place_of_birth',
        'date_of_birth',
        'phone',
        'address',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Role Helpers
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isUser(): bool
    {
        return $this->role === 'user' || empty($this->role);
    }

    public function isAdminOrPetugas(): bool
    {
        return in_array($this->role, ['admin', 'petugas']);
    }

    /**
     * Access control for Filament Admin Panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdminOrPetugas();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
