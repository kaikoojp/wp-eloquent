<?php

namespace WeDevs\ORM\WP;

use WeDevs\ORM\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'usermeta';
    protected $primaryKey = 'umeta_id';

    public $timestamps = false;
    protected $casts = [
        'umeta_id' => 'integer',
        'user_id'  => 'integer',
    ];
}