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

    /**
     * @test
     */
    public function findのテスト()
    {
        $post = Post::find(1);
        $this->assertEquals(1, $post->getAttribute('ID'));
    }

    /**
     * @test
     */
    public function parentとchildsのテスト()
    {
        $post = new Post(['post_title' => 'test', 'post_parent' => 1]);
        $post->save();
        $this->assertContains($post->getAttribute('ID'), Post::with(['childs'])->find(1)->childs->pluck('ID'));
        $this->assertEquals(1, $post->parent->getAttribute('ID'));
    }

    /**
     * @test
     */
    public function rootのテスト()
    {
        $post = new Post(['post_title' => 'test', 'post_parent' => 1]);
        $post->save();
        for($i = 0; $i < 5; $i++) {
            $child = new Post(['post_title' => sprintf('child: %d', $post->getAttribute('ID'))]);
            $post->childs()->save($child);
            $post = $child;
        }
        $this->assertEquals(1, $child->root()->getAttribute('ID'));

        $this->assertNull(Post::find(1)->root());
    }
}