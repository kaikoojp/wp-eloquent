<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-18
 * Time: 16:06
 */

namespace WeDevs\ORM\WP\Term;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use WeDevs\ORM\Eloquent\Model;

/**
 * Class Term
 * @package WeDevs\ORM\WP\Term
 * @method static self taxonomy(string $name, string $taxonomy)
 */
class Term extends Model
{
    protected $table = 'terms';
    protected $primaryKey = 'term_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'term_id'    => 'integer',
        'term_group' => 'integer',
    ];

    /**
     * @param Builder $builder
     * @param string  $name
     * @param string  $taxonomy
     * @return self
     */
    public function scopeTaxonomy(Builder $builder, string $name, string $taxonomy): self
    {
        return $builder->where('name', $name)->with(['taxonomies' => static function (HasMany $relation) use ($taxonomy) {
            $relation->where('taxonomy', '=', $taxonomy);
        }])->first();
    }

    /**
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(TermMeta::class, 'term_id');
    }

    /**
     * @return HasMany
     */
    public function taxonomies(): HasMany
    {
        return $this->hasMany(TermTaxonomy::class, 'term_id', 'term_id');
    }
}