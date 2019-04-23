
<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-18
 * Time: 16:02
 */

namespace WeDevs\ORM\WP\Term;

use WeDevs\ORM\Eloquent\Model;

class TermMeta extends Model
{
    protected $table = 'term_meta';
    protected $fillable = ['meta_key', 'meta_value'];
    protected $primaryKey = 'meta_id';
    protected $casts = [
        'meta_id',
        'term_id',
    ];
}