<?php

namespace App\Models;

class Image extends BaseModel
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
    protected $table = 'api_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'person_id', 'filename', 'filename_url', 'thumbnail', 'rating', 'thumbs_up', 'thumbs_down', 'hash', 'social_id', 'nominated', 'active', 'created_at'
    ];

    /**
     * @return string
     */
    public function getUriAttribute() {
        return "http://www.witnessyourworld.com/media/users/{$this->person->wyw_user_id}/{$this->thumbnail}";
    }

    /**
     * Get the user that owns the image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * The keywords that belong to the image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'api_image_keywords_links')->withPivot(['auto', 'user']);
    }

    /**
     * The colors that belong to the image.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'api_image_colors_links', 'image_id', 'color_id')
            ->withPivot('density');
    }

    /**
     * The artworks that have this image
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artworks() {
        return $this->belongsToMany(Artwork::class, 'api_artwork_image_links', 'image_id', 'artwork_id')
            ->withPivot(['type', 'position']);
    }

    /**
     * Get all of the Image's comments.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

//    /**
//     * Get all of the Image's comments.
//     */
//    public function searchResults()
//    {
//        return $this->morphMany(SearchResult::class, 'commentable');
//    }

//    /**
//     * Get the Image's search result.
//     */
//    public function submissions()
//    {
//        return $this->morphOne(Submission::class, 'searchable');
//    }

//    public function submission() {
//        return $this->hasOne(Submission::class);
//    }

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

    /**
     * Formatted result with joined user and keywords
     *
     * @return array
     */
    public function getFormatted() {

        $keywords = [];
        foreach ($this->keywords as $keyword) {
            $keywords[] = $keyword->keyword;
        }
        $colors = [];
        foreach ($this->colors as $color) {
            $colors[$color->hex] = ['w3c_name' => $color->w3c_name, 'w3c_hex' => $color->w3c_hex];
        }

        $hasPerson = $this->person instanceof Person;
//        var_dump(get_class($this->person));
//        echo "\n" . __DIR__ . '/../../../public/media/users/' . $this->user_id . '/' . $this->thumbnail;

        return [
            'id' => $this->id,
            'person' => $hasPerson ? ($this->person->first_name . ' ' . $this->person->last_name) : '',
            'person_id' => $this->person_id,
            'wyw_user_id' => $hasPerson ? $this->person->wyw_user_id : '',
            'filename' => $this->filename,
            'path' => $hasPerson ? base_path('web') . '/media/users/' . $this->person->wyw_user_id . '/' . $this->filename : '',
//            'thumbnail' => file_exists(__DIR__ . '/../../../public/media/users/' . $this->user_id . '/' . $this->thumbnail) ? $this->thumbnail : false,
            'thumbnail' => $this->thumbnail,
            'keywords' => $keywords,
            'colors' => $colors,
            'rating' => $this->rating,
            'thumbs_up' => $this->thumbs_up,
            'thumbs_down' => $this->thumbs_down,
            'hash' => $this->hash,
            'social_id' => $this->social_id,
            'nominated' => (bool) $this->nominated,
            'active' => (bool) $this->active,
            'weight' => !empty($this->weighed) ? $this->weighed : ''
        ];
    }

}
