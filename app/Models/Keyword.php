<?php

namespace App\Models;

class Keyword extends BaseModel
{

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
    protected $table = 'api_image_keywords';

    /**
     * Disables automatic timestamp columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'keyword', 'amount', 'selectable' ];

    /**
     * The images that belong to the keyword.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'api_image_keywords_links')->withPivot(['auto', 'user']);
    }

    /**
     * Get the entries belonging to the image.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * Formatted result with joined images
     * @return array
     */
    public function getFormatted() {

        $images = [];
//        foreach ($this->images as $image) {
//            $images[] = $image->thumbnail;
//        }
//        $colors = [];
//        foreach ($this->colors as $color) {
//            $colors[$color->hex] = ['w3c_name' => $color->w3c_name, 'w3c_hex' => $color->w3c_hex];
//        }
//        echo "\n" . __DIR__ . '/../../../public/media/users/' . $this->user_id . '/' . $this->thumbnail;
        return [
            'id' => $this->id,
            'keyword' => $this->keyword,
            'amount' => $this->amount,
            'images' => $images,
//            'colors' => $colors,
        ];
    }



}
