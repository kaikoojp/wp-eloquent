<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-18
 * Time: 16:04
 */

namespace WeDevs\ORM\WP\Term;

use WeDevs\ORM\Eloquent\Model;

class TermRelationShip extends Model
{
    protected $table = 'term_relationships';
    protected $primaryKey = 'term_taxonomy_id';
}