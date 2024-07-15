<?php

namespace App\Models;

use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TomatoPHP\FilamentAccounts\Models\AccountRequest;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use TomatoPHP\FilamentAccounts\Traits\InteractsWithTenant;
use TomatoPHP\FilamentLocations\Models\Location;

/**
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $loginBy
 * @property string $type
 * @property string $address
 * @property string $password
 * @property string $otp_code
 * @property string $otp_activated_at
 * @property string $last_login
 * @property string $agent
 * @property string $host
 * @property integer $attempts
 * @property boolean $login
 * @property boolean $activated
 * @property boolean $blocked
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property AccountsMeta[] $accountsMetas
 * @property Model meta($key, $value)
 * @property Location[] $locations
 */
class Account extends Authenticatable implements HasMedia, HasAvatar, HasTenants
{
    use InteractsWithMedia;
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use InteractsWithTenant;

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'phone',
        'parent_id',
        'type',
        'name',
        'username',
        'loginBy',
        'address',
        'password',
        'otp_code',
        'otp_activated_at',
        'last_login',
        'agent',
        'host',
        'is_login',
        'is_active',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_login' => 'boolean',
        'is_active' => 'boolean'
    ];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
        'otp_activated_at',
        'last_login',
    ];

    protected $appends = [
        'birthday',
        'gender'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
        'otp_activated_at',
        'host',
        'agent',
    ];

    /**
     * @return string|null
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return  $this->getFirstMediaUrl('avatar')?? null;
    }

    /**
     * @return Model|string|null
     */
    public function getBirthdayAttribute(): Model|string|null
    {
        return $this->meta('birthday') ?: null;
    }

    /**
     * @return Model|string|null
     */
    public function getGenderAttribute(): Model|string|null
    {
        return $this->meta('gender') ?: null;
    }


    /**
     * @return HasMany
     */
    public function accountsMetas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('TomatoPHP\FilamentAccounts\Models\AccountsMeta');
    }


    /**
     * @param string $key
     * @param string|array|object|null $value
     * @return Model|string|array|null
     */
    public function meta(string $key, string|array|object|null $value=null): Model|string|null|array
    {
        if($value!==null){
            if($value === 'null'){
                return $this->accountsMetas()->updateOrCreate(['key' => $key], ['value' => null]);
            }
            else {
                return $this->accountsMetas()->updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }
        else {
            $meta = $this->accountsMetas()->where('key', $key)->first();
            if($meta){
                return $meta->value;
            }
            else {
                return $this->accountsMetas()->updateOrCreate(['key' => $key], ['value' => null]);
            }
        }
    }



    /**
     * @return MorphMany
     */
    public function locations(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Location::class, 'modelbale', 'model_type', 'model_id');
    }

    /**
     * @return HasMany
     */
    public function requests(): HasMany
    {
        return $this->hasMany(AccountRequest::class, 'account_id', 'id');
    }
}
