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
use WeDevs\ORM\WP\Post;

class TermTaxonomy extends Model
{
    protected $table = 'term_taxonomy';
    protected $primaryKey = 'term_taxonomy_id';
    public $timestamps = false;
    protected $fillable = [
        'taxonomy',
    ];

    /**
     * @return BelongsTo
     */
    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id', 'term_id');
    }

    public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            $this->getTablePrefix() . 'term_relationships',
            'term_taxonomy_id',
            'object_id',
            'term_taxonomy_id',
            'ID'
        );
    }
}