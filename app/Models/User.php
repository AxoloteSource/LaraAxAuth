<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public static function register(
        string $email,
        string $name,
        string $password,
        int $roleId = RoleEnum::Customer->value
    ): User {
        $user = new User;
        $user->email = $email;
        $user->name = $name;
        $user->role_id = $roleId;
        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }

    public static function login(
        string $email,
        string $password
    ): ?User {
        if (! auth()->attempt(['email' => $email, 'password' => $password])) {
            return null;
        }
        return User::where('email', $email)->first();
    }

    public function logout()
    {
        $userSesion = auth()->user();

        if (!$userSesion) {
            return null;
        }

        return $userSesion->currentAccessToken()->delete();
    } 
}
