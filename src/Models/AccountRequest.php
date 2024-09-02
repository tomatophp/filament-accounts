<?php

namespace TomatoPHP\FilamentAccounts\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $account_id
 * @property integer $user_id
 * @property string $type
 * @property string $status
 * @property boolean $is_approved
 * @property string $is_approved_at
 * @property string $created_at
 * @property string $updated_at
 * @property AccountRequestMeta[] $accountRequestMetas
 * @property Account $account
 * @property User $user
 */
class AccountRequest extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['account_id', 'user_id', 'type', 'status', 'is_approved', 'is_approved_at', 'created_at', 'updated_at'];

    protected $casts = [
        'is_approved' => 'boolean'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountRequestMetas()
    {
        return $this->hasMany('TomatoPHP\FilamentAccounts\Models\AccountRequestMeta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(config('filament-accounts.model'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    /**
     * @param string $key
     * @param string|null $value
     * @return Model|string
     */
    public function meta(string $key, mixed $value=null): mixed
    {
        if($value!==null){
            return $this->accountRequestMetas()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        else {
            $value = $this->accountRequestMetas()->where('key', $key)->first()?->value;
            if($value === 'image'){
                return $this->accountRequestMetas()->where('key', $key)->first()?->getMedia('image')->first()?->getUrl();
            }
            else {
                return $this->accountRequestMetas()->where('key', $key)->first()?->value;
            }
        }
    }
}
