<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-18
 * Time: 15:54
 */

namespace WeDevs\ORM\WP;

use WeDevs\ORM\WP\Term\Term;

class Category extends Term
{
    protected $taxonomy = 'category';
}