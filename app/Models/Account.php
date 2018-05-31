<?php

namespace App\Models;


class Account extends BaseModel
{

    /**
     * @return int
     */
    public function getNumberAttribute()
    {
        return $this->getKey() ?: 0;
    }


    /**
     * The connection name for the model.
     *
     * @var string
    protected $connection = 'api';
     */


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_person_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'person_id', 'provider', 'reference', 'url', 'image', 'oauth_token', 'oauth_secret', 'active'
    ];

    /**
     * Get the person belonging to this account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

}
