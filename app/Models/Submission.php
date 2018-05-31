<?php

namespace App\Models;

class Submission extends VirtualModel {

//    use \Illuminate\Database\Eloquent\Concerns\HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'searchable_id', 'searchable_type', 'created_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function searchable() {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery() {
        return Image::query();
    }

//    public function newEloquentBuilder() {
//        return Image
//    }

}