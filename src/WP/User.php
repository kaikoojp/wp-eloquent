<?php

namespace WeDevs\ORM\WP;


use Illuminate\Database\Eloquent\Relations\HasMany;
use WeDevs\ORM\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'ID';
    protected $timestamp = false;

    /**
     * @return HasMany
     */
    public function meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }
}