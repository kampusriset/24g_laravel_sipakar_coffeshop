<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'role', 'google_id'];
    protected $hidden = ['password', 'remember_token'];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}