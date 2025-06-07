<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\EnumRoleName;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Task;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens , HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class , 'role_user' , 'user_id' , 'role_id')
            ->withTimestamps();
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class , 'permission_user', 'user_id' , 'permission_id')
            ->withTimestamps();
    }

    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function isAdmin(): bool
    {
        return $this->roles()->where('name', 'admin')->exists();
    }

    public function isUser(): bool
    {
        return $this->hasRole('user');
    }


}
