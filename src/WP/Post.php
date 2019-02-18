<?php

namespace WeDevs\ORM\WP;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use WeDevs\ORM\Eloquent\Model;
use WeDevs\ORM\WP\Term\TermRelationShip;
use WeDevs\ORM\WP\Term\TermTaxonomy;

/**
 * Class Post
 *
 * @package WeDevs\ORM\WP
 * @method static self find(Integer $id)
 */
class Post extends Model
{
    protected $table = 'posts';
    protected $post_type = null;
    protected $primaryKey = 'ID';

    const CREATED_AT = 'post_date';
    const UPDATED_AT = 'post_modified';

    protected $fillable = [
        'post_title',
        'post_parent'
    ];

    protected $casts = [
        'ID' => 'integer',
        'post_parent' => 'integer',
    ];

    public function newQuery()
    {
        $query = parent::newQuery();
        if($this->post_type !== null) {
            return $this->scopeType($query, $this->post_type);
        }
        return $query;
    }

    /**
     * Filter by post type
     *
     * @param $query
     * @param string $type
     *
     * @return mixed
     */
    public function scopeType($query, $type = 'post')
    {
        return $query->where('post_type', '=', $type);
    }

    /**
     * Filter by post status
     *
     * @param $query
     * @param string $status
     *
     * @return mixed
     */
    public function scopeStatus($query, $status = 'publish')
    {
        return $query->where('post_status', '=', $status);
    }

    /**
     * Filter by post author
     *
     * @param $query
     * @param null $author
     *
     * @return mixed
     */
    public function scopeAuthor($query, $author = null)
    {
        if ($author) {
            return $query->where('post_author', '=', $author);
        }
    }

    /**
     * Get comments from the post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_post_ID');
    }

    /**
     * Get meta fields from the post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany(PostMeta::class, 'post_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, 'post_parent', 'ID');
    }

    /**
     * @return HasMany
     */
    public function childs()
    {
        return $this->hasMany(static::class, 'post_parent', 'ID');
    }

    /**
     * @return HasManyThrough
     */
    public function terms()
    {
        return $this->hasManyThrough(
            TermTaxonomy::class,
            TermRelationShip::class,
            'object_id',
            'term_taxonomy_id'
        )->with('term');
    }

    /**
     * @return null|Post
     */
    public function root()
    {
        $posts = $this->scopeType($this->newQuery())->get(['ID', 'post_parent'])->pluck(null, 'ID')->toArray();
        $func = function(array $posts, int $id) use(&$func) {
            if($posts[$id]['post_parent'] === 0) {
                return $id;
            }
            return $func($posts, $posts[$id]['post_parent']);
        };
        $root = $func($posts, $this->getAttribute('ID'));
        return $root === $this->getAttribute('ID') ? null : static::find($root);
    }
}