<?php

namespace WeDevs\ORM\WP;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use WeDevs\ORM\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'comment_ID';

    protected $casts = [
        'comment_ID'      => 'integer',
        'comment_post_ID' => 'integer',
        'user_id'         => 'integer',
        'comment_parent'  => 'integer',
    ];

    /**
     * Post relation for a comment
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'comment_post_ID');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Parent Post
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'comment_parent', 'comment_ID');
    }
}