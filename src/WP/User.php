<?php

namespace WeDevs\ORM\WP;

use Illuminate\Database\Eloquent\Relations\HasMany;
use WeDevs\ORM\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'ID';
    protected $timestamp = false;
    protected $casts = [
        'ID'              => 'integer',
        'user_registered' => 'integer',
        'user_status'     => 'integer',
    ];

    /**
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }
}