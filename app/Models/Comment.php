<?php

namespace App\Models;

class Comment extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'body', 'commentable_id', 'commentable_type'
    ];

    /**
     * Get all of the owning commentable models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
