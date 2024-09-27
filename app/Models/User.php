<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\EmailTypeEnum;
use App\Enums\RoleIdEnum;
use App\Enums\UserStatusIdEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /*public static function store(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $nickname,
        ?string $phoneCodeIso2 = null,
        ?string $phoneNumber = null,
        int $roleIdEnum,
        UserStatusIdEnum $userStatusId = UserStatusIdEnum::PendingUploadDocuments,
        ?string $referralNickName = null
    ): User {
        $user = new User();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->nickname = $nickname;
        $user->user_status_id = $userStatusId->value;
        $user->role_id = $roleIdEnum->value;

        if ($phoneCodeIso2 && $phoneNumber) {
            $phoneCode = PhoneCode::where('phone_code', $phoneCodeIso2)->first();
            $user->phone_code_id = $phoneCode->id;
            $user->phone_number = $phoneNumber;
        }

        $user->save();
        $user->userStatus;
        $user->phoneCode;

        self::prepareQueue(EmailTypeEnum::NewUser, $user, $email);
        if (!$referralNickName) {
            return $user;
        }

        User::findByNickName($referralNickName)?->registerReferrals($user);

        return $user;
    }*/
}
