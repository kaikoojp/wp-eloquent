<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-18
 * Time: 16:01
 */

namespace WeDevs\ORM\WP\Term;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use WeDevs\ORM\Eloquent\Model;

class TermTaxonomy extends Model
{
    protected $table = 'term_taxonomy';

    /**
     * @return BelongsTo
     */
    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id', 'term_id');
    }
}