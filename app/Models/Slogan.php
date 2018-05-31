<?php

namespace App\Models;


class Slogan extends BaseModel
{

    const NUMBER_PREFIX = 4;

    /**
     * @return int
     */
    public function getNumberAttribute()
    {
        return self::NUMBER_PREFIX . $this->getKey() ?: 0;
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
    protected $table = 'api_slogans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'slogan', 'rating', 'thumbs_up', 'thumbs_down', 'active'];

    /**
     * Get the user that owns the slogan.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * The tags that belong to the sogan.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'api_slogan_tags_links')->withPivot(['auto', 'user']);
    }

    /**
     * The artworks that have this slogan
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artworks() {
        return $this->belongsToMany(Artwork::class, 'api_artwork_slogan_links', 'slogan_id', 'artwork_id')
            ->withPivot(['type', 'position']);
    }


    /**
     * Get all of the Slogan's comments.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /*
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $args
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderAndFilter($query, $args) {

        $orderBy = @$args['orderBy'] ?: 'createdAt_DESC';

        @list ($orderField, $orderDirection) = explode('_', $orderBy);
        $orderDirection = $orderDirection ?: 'DESC';

        return $query->orderBy(snake_case($orderField), strtolower($orderDirection));

    }


    /**
     * Formatted result with joined user and tags
     * @return array
     */
    public function getFormatted() {

        $tags = [];
        foreach ($this->tags as $tag) {
            $tags[] = $tag->tag;
        }
        $hasPerson = $this->person instanceof Person;

        return [
            'id' => $this->id,
            'person' => $hasPerson ? ($this->person->first_name . ' ' . $this->person->last_name) : '',
            'person_id' => $this->person_id,
            'wyw_user_id' => $hasPerson ? $this->person->wyw_user_id : '',
            'tags' => $tags,
            'rating' => $this->rating,
            'thumbs_up' => $this->thumbs_up,
            'thumbs_down' => $this->thumbs_down,
            'nominated' => (bool) $this->nominated,
            'active' => (bool) $this->active,
        ];
    }

}
