<?php

namespace WeDevs\ORM\WP;

use WeDevs\ORM\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'usermeta';
    protected $primaryKey = 'meta_id';

    public $timestamps = false;

}