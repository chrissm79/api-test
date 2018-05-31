<?php

namespace App\Models;

use Carbon\Carbon;

class Entry extends BaseModel
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
    protected $table = 'api_person_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'person_id', 'keyword_id', 'color_id'
    ];

    /**
     * Get the User who created this entry.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the Keyword that belongs to this entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keyword()
    {
        return $this->belongsTo(Keyword::class);
    }

    /**
     * Get the Color that belongs to this entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Formatted result with joined user, keyword and color
     *
     * @return array
     */
    public function getFormatted() {

        $hasPerson = $this->person instanceof Person;
        $hasKeyword = $this->keyword instanceof Keyword;
        $hasColor = $this->color instanceof Color;
//        echo "\n" . __DIR__ . '/../../../public/media/users/' . $this->user_id . '/' . $this->thumbnail;
        return [
            'id' => $this->id,
            'person' => $hasPerson ? $this->person->name : '',
            'email' => $hasPerson ? $this->person->email : '',
            'person_id' => $this->person_id,
            'keyword' => $hasKeyword ? $this->keyword->keyword : '',
            'keyword_id' => $this->keyword_id,
            'color' => $hasColor ? $this->color->w3c_hex : '',
            'color_id' => $this->color_id,
            'keywords' => explode(',', $this->keywords),
            'colors' => explode(',', $this->colors),
            'profile_picture' => $hasPerson ? $this->person->profile_picture : '',
            'profile_picture_cropped' => $hasPerson ? $this->person->profile_picture_cropped : '',
            'profile_animation' => $hasPerson ? $this->person->profile_animation : '',
            'has_video' => $hasPerson && $this->person->has_video ? true : false,
            'video_url' => $hasPerson ? $this->person->video_url : '',
            'source' => $hasPerson ? $this->person->source : '',
            'created_at' => Carbon::parse($hasPerson ? $this->person->created_at : $this->created_at)->toDateTimeString(),
        ];
    }


}
