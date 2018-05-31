<?php

namespace App\Models;


class Artwork extends BaseModel
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

    const UPDATED_AT = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_artworks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'filename', 'filename_url', 'thumbnail', 'rating', 'thumbs_up', 'thumbs_down',
        'created_at', 'selected_at', 'type'
    ];

    /**
     * @return string
     */
    public function getUriAttribute() {
        return "http://www.witnessyourworld.com/media/works/{$this->id}/{$this->filename}";
    }



    public function searchable() {
        return $this->belongsTo(SearchResult::class);
    }

//    /**
//     * Get the users that contributed to the work.
//     *
//     * @returns Collection
//     */
//    public function persons()
//    {
//        return $this->hasManyThrough();
//    }

    /**
     * Get the images that contributed to the work.
     *
     * @returns \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'api_artwork_image_links')
            ->withPivot(['type', 'position']);
    }

    /**
     * Get the images that contributed to the work.
     *
     * @returns \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function slogans()
    {
        return $this->belongsToMany(Slogan::class, 'api_artwork_slogan_links')
            ->withPivot(['type', 'position']);
    }


    /**
     * Get all of the Art's comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
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

        return $query->orderBy(snake_case($orderField), strtolower($orderDirection));

    }

}
