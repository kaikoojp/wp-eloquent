<?php

namespace WeDevs\ORM\WP;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use WeDevs\ORM\Eloquent\Model;
use WeDevs\ORM\WP\Term\TermTaxonomy;

/**
 * Class Post
 * @package WeDevs\ORM\WP
 * @mixin Builder
 */
class Post extends Model
{
    const STATUS_PUBLISH = 'publish';
    const STATUS_FUTURE = 'future';
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PRIVATE = 'private';
    const STATUS_TRASH = 'trash';

    protected $table = 'posts';
    protected $post_type = null;
    protected $primaryKey = 'ID';

    const CREATED_AT = 'post_date';
    const UPDATED_AT = 'post_modified';

    protected $fillable = [
        'post_title',
        'post_parent',
    ];

    protected $casts = [
        'ID'            => 'integer',
        'author'        => 'integer',
        'post_parent'   => 'integer',
        'post_date'     => 'datetime',
        'post_modified' => 'datetime',
        'menu_order'    => 'integer',
        'comment_count' => 'integer',
    ];

    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        $query = parent::newQuery();
        if ($this->post_type !== null) {
            return $this->scopeType($query, $this->post_type);
        }
        return $query->whereNotIn('post_status', [self::STATUS_TRASH]);
    }

    /**
     * Filter by post type
     * @param Builder $query
     * @param string  $type
     * @return Builder
     */
    public function scopeType(Builder $query, $type = 'post'): Builder
    {
        return $query->where('post_type', '=', $type);
    }

    /**
     * Filter by post status
     * @param Builder      $query
     * @param string|array $status
     * @return Builder
     */
    public function scopeStatus(Builder $query, $status = 'publish'): Builder
    {
        if (is_array($status)) {
            return $query->whereIn('post_status', $status);
        }
        return $query->where('post_status', '=', $status);
    }

    /**
     * Filter by post type publish only
     * @param Builder $query
     * @return mixed
     */
    public function scopePublished(Builder $query): Builder
    {
        return $this->scopeStatus($query, 'publish');
    }

    /**
     * Filter by post type draft only
     * @param Builder $query
     * @return Builder
     */
    public function scopeDrafted(Builder $query): Builder
    {
        return $this->scopeStatus($query, 'draft');
    }

    /**
     * Filter by post author
     * @param Builder $query
     * @param string  $author
     * @return Builder
     */
    public function scopeAuthor(Builder $query, $author = ''): Builder
    {
        if ($author !== '') {
            return $query->where('post_author', '=', $author);
        }
    }

    /**
     * Get comments from the post
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'comment_post_ID');
    }

    /**
     * Get meta fields from the post
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(PostMeta::class, 'post_id');
    }

    /**
     * Get Parent Post
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'post_parent', 'ID');
    }

    /**
     * Get Child Post
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'post_parent', 'ID');
    }

    /**
     * Get TermTaxonomy
     * @return BelongsToMany
     */
    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(
            TermTaxonomy::class,
            $this->getTablePrefix() . 'term_relationships',
            'object_id',
            'term_taxonomy_id',
            'ID',
            'term_taxonomy_id'
        );
    }

    /**
     * Filter by category On TermTaxonomy
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->terms()->where('taxonomy', 'category');
    }

    /**
     * Get Parent Root Post
     * @return null|static
     */
    public function root()
    {
        $posts = $this->scopeType($this->newQuery())->get(['ID', 'post_parent'])->pluck(null, 'ID')->toArray();
        $func = function (array $posts, int $id) use (&$func) {
            if ($posts[$id]['post_parent'] === 0) {
                return $id;
            }
            return $func($posts, $posts[$id]['post_parent']);
        };
        $root = $func($posts, $this->getAttribute('ID'));
        return $root === $this->getAttribute('ID') ? null : static::find($root);
    }
}