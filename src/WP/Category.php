<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-18
 * Time: 15:54
 */

namespace WeDevs\ORM\WP;

use WeDevs\ORM\Eloquent\Model;

class Category extends Model
{
    protected $table = 'terms';
    protected $primaryKey = 'term_id';
    protected $taxonomy = 'category';

}