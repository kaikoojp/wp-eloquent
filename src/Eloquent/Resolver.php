<?php
namespace WeDevs\ORM\Eloquent;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface;

class Resolver implements ConnectionResolverInterface
{

    /**
     * Get a database connection instance.
     *
     * @param  string $name
     *
     * @return ConnectionInterface
     */
    public function connection( $name = null ): ConnectionInterface
    {
        return Database::instance();
    }

    /**
     * Get the default connection name.
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        // TODO: Implement getDefaultConnection() method.
    }

    /**
     * Set the default connection name.
     *
     * @param  string $name
     *
     * @return void
     */
    public function setDefaultConnection( $name ) {
        // TODO: Implement setDefaultConnection() method.
    }
}