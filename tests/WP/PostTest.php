<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-12
 * Time: 14:36
 */

namespace WeDevs\ORM\Test\WP;

use PHPUnit\Framework\TestCase;
use WeDevs\ORM\WP\Post;

class PostTest extends TestCase
{
    /**
     * @test
     */
    public function cursorのテスト()
    {
        foreach(Post::cursor() as $index => $post) {
            $this->assertEquals($index + 1, $post->getAttribute('ID'));
        }
    }
}