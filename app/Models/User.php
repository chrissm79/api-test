<?php

namespace App\Models;

class User extends \App\Auth\User
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'client_id', 'is_active', 'last_login_at', 'last_request_at', 'password', 'created_at'
    ];

    protected $casts = [
        'admin' => 'boolean',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'deleted_at', 'remember_token'
    ];

    /**
     * Get the client that owns the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(\Laravel\Passport\Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function person() {
        return $this->hasOne(Person::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        error_log("User::images called.." . get_class($this->person->images()), 3, '/tmp/debug.txt');

        return $this->person->images();
//        return Image::query()->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function slogans()
    {
        return Image::query()->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function artworks()
    {
        return Image::query()->orderBy('created_at', 'desc');
    }

//    public function submissions()
//    {
////        die (Submission::query()->toSql());
//        return Submission::query()->with(['image', 'slogan'])->orderBy('created_at', 'desc');
//    }

    /**
     * Automatically hash password
     * @param $value
     * @return string|null
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = app('hash')->make($value);
        }
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $args
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderAndFilter($query, $args) {


        $orderBy = @$args['orderBy'] ?: 'createdAt_DESC';

        @list ($orderField, $orderDirection) = explode('_', $orderBy);
        $orderDirection = $orderDirection ?: 'DESC';

        $query->where('first_name', '<>',  "");

        return $query->orderBy(snake_case($orderField), strtolower($orderDirection));

    }

}
