<?php

namespace WeDevs\ORM\WP;

use WeDevs\ORM\Eloquent\Model;

class PostMeta extends Model
{
    protected $table = 'postmeta';
    protected $primaryKey = 'meta_id';
    public $timestamps = false;

    protected $casts = [
        'meta_id' => 'integer',
        'post_id' => 'integer',
    ];
}