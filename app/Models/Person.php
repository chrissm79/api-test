<?php

namespace App\Models;


class Person extends BaseModel
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
    protected $table = 'api_persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name', 'last_name', 'email', 'location', 'country', 'last_login', 'active', 'source', 'profile_picture', 'profile_image_url', 'profile_picture_cropped', 'profile_animation', 'has_video', 'video_url', 'wyw_user_id', 'user_id'
    ];

    /**
     * @return mixed
     */
    public function getJoinedAtAttribute() {
        return $this->created_at;
    }

    /**
     * @param null $value
     * @return mixed|null|string
     */
    public function getProfileImageUrlAttribute($value = null) {

        if (!empty($value)) {
            return $value;
        }

        if (strpos($this->profile_picture, 'http') !== false) {
            return $this->profile_picture;
        }

        return "http://www.witnessyourworld.com/media/users/{$this->wyw_user_id}/{$this->profile_picture}";

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the entries belonging to the user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * Get the entries belonging to the user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Get the comments for the blog post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
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

    /**
     * @return array
     */
    public function getFormatted() {
        return $this->toArray();
    }


}
