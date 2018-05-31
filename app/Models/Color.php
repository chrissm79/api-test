<?php

namespace App\Models;

class Color extends BaseModel
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
    protected $table = 'api_image_colors';

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
    protected $fillable = ['hex', 'amount', 'w3c_name', 'w3c_hex', 'w3c_amount', 'hue', 'saturation', 'lightness'];

    /**
     * The images that belong to the keyword.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'api_image_colors_links', 'image_id', 'color_id')
            ->withPivot('density');
    }

    /**
     * Get the entries belonging to the color.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }



}
