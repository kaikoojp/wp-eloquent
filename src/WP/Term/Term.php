<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-18
 * Time: 16:06
 */

namespace WeDevs\ORM\WP\Term;

use Illuminate\Database\Eloquent\Relations\HasMany;
use WeDevs\ORM\Eloquent\Model;

class Term extends Model
{
    protected $table = 'terms';
    protected $primaryKey = 'term_id';

    /**
     * @return HasMany
     */
    public function metas()
    {
        return $this->hasMany(TermMeta::class, 'term_id');
    }

    /**
     * @return HasMany
     */
    public function taxonomies()
    {
        return $this->hasMany(TermTaxonomy::class, 'term_id', 'term_id');
    }
}