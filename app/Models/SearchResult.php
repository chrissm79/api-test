<?php

namespace App\Models;

use GraphQL\Type\Definition\Type;
use Illuminate\Database\DatabaseManager;
use Nuwave\Lighthouse\Schema\NodeContainer;
use Nuwave\Lighthouse\Schema\Types\ConnectionField;
use Nuwave\Lighthouse\Schema\Types\PaginatorField;
use Nuwave\Lighthouse\Support\DataLoader\QueryBuilder;
use Nuwave\Lighthouse\Support\Traits\IsRelayConnection;

class SearchResult extends VirtualModel {

    use IsRelayConnection;

//    use \Illuminate\Database\Eloquent\Concerns\HasRelationships;

    protected $fillable = [
        'id', 'searchable_id', 'searchable_type', 'created_at'
    ];

    public function getKeyName() {
        return 'id';
    }

    public static function query($root = null, array $args = null) {

        error_log(__FILE__.__LINE__, 3, '/tmp/debug.txt');
        $images = Image::query()
            ->select(['id', 'filename as data', 'rating'])
            ;

        $slogans = Slogan::query()
            ->select(['id', 'slogan as data', 'rating'])
        ;

        $artworks = Artwork::query()
            ->select(['id', 'rating as data', 'rating'])
            ->union($images)
            ->union($slogans)
        ;

//        return new QueryBuilder($artworks->get());
        return $artworks;
    }


    public function newQuery() {
        return Image::query();
    }

    public function getConnectionName() {
        return true;
    }

//    public function resolve()
//    {
//        $data = Image::orderBy('id', 'DESC')->relayConnection($this->args);
//        $pageInfo = (new ConnectionField)->pageInfoResolver($data,$this->args,$this->context,$this->info);
//
//        $page = $data->currentPage();
//        $edges = $data->values()->map(function ($item, $x) use ($page) {
//            $cursor = ($x + 1) * $page;
//            $encodedCursor = $this->encodeGlobalId('Car', $cursor);
//            $globalId = $this->encodeGlobalId('Car', $item->getKey());
//            $item->_id = $globalId;
//            return ['cursor' => $encodedCursor, 'node' => $item];
//        });
//
//
//        return [
//            'pageInfo' => $pageInfo,
//            'edges' =>  $edges,
//        ];
//    }
//    public

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
//     */
//    public function searchable() {
//        return $this->morphTo();
//    }
//
//    public function newQuery() {
//        die('REEE');
//    }
////    public function newEloquentBuilder() {
////        return Image
////    }

}