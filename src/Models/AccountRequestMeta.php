<?php

namespace TomatoPHP\FilamentAccounts\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $account_request_id
 * @property integer $model_id
 * @property string $model_type
 * @property string $key
 * @property mixed $value
 * @property boolean $is_approved
 * @property string $is_approved_at
 * @property boolean $is_rejected
 * @property string $is_rejected_at
 * @property string $rejected_reason
 * @property string $created_at
 * @property string $updated_at
 * @property AccountRequest $accountRequest
 * @property User $user
 */
class AccountRequestMeta extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'account_request_id', 'model_id', 'model_type', 'key', 'value', 'is_approved', 'is_approved_at', 'is_rejected', 'is_rejected_at', 'rejected_reason', 'created_at', 'updated_at'];

    protected $casts = [
        'value' => 'json',
        'is_approved' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountRequest()
    {
        return $this->belongsTo('TomatoPHP\FilamentAccounts\Models\AccountRequest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
