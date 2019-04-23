<?php

namespace WeDevs\ORM\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;

/**
 * Model Class
 * @package WeDevs\ERP\Framework
 * @mixin Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
abstract class Model extends Eloquent
{

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        static::$resolver = new Resolver();
        parent::__construct($attributes);
    }

    /**
     * Set the table associated with the model.
     * @param  string $table
     * @return $this
     */
    public function setTable($table): self
    {
        $this->table = str_replace($this->getTablePrefix(), '', $table);
        return $this;
    }

    /**
     * Get the table associated with the model.
     * Append the WordPress table prefix with the table name if
     * no table name is provided
     * @return string
     */
    public function getTable(): string
    {
        if (isset($this->table)) {
            return $this->getTablePrefix() . $this->table;
        }
        $table = str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
        return $this->getTablePrefix() . $table;
    }

    /**
     * @return string
     */
    public function getTablePrefix(): string
    {
        return $this->getConnection()->db->prefix;
    }
}