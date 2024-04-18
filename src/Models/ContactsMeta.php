<?php

namespace TomatoPHP\FilamentAccounts\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $contact_id
 * @property integer $model_id
 * @property string $model_type
 * @property string $key
 * @property mixed $value
 * @property string $created_at
 * @property string $updated_at
 * @property Contact $contact
 */
class ContactsMeta extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['contact_id', 'model_id', 'model_type', 'key', 'value', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('TomatoPHP\FilamentAccounts\Models\Contact');
    }
}
