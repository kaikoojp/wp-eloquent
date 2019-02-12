<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-12
 * Time: 13:20
 */

namespace WeDevs\ORM\Test\Eloquent;


use PHPUnit\Framework\TestCase;
use WeDevs\ORM\Eloquent\Database;

class DatabaseTest extends TestCase
{
    /**
     * @test
     */
    public function 接続テスト()
    {
        $instance = Database::instance();
        $post = $instance->table('posts')->find(1);
        $this->assertEquals('hello-world', $post->post_name);
    }

    /**
     * @test
     */
    public function cursorのテスト()
    {
        $instance = Database::instance();
        $cursor = $instance->cursor('SELECT * FROM wp_posts');
        foreach($cursor as $index => $post) {
            $this->assertEquals($index + 1, $post['ID']);
        }
    }
}
