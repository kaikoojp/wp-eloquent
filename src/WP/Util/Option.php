<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-22
 * Time: 15:12
 */

namespace WeDevs\ORM\WP\Util;

use WeDevs\ORM\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';
    protected $primaryKey = 'option_id';
    protected $fillable = [
        'option_name',
        'option_value',
    ];
    protected $hidden = [
        'option_id',
    ];

    protected $casts = [
        'option_id' => 'integer',
    ];

    public $timestamps = false;
}