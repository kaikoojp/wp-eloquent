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
use WeDevs\ORM\WP\Term\Term;
use WeDevs\ORM\WP\Term\TermTaxonomy;
use WeDevs\ORM\WP\User;

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
    public function parentとchildrenのテスト()
    {
        $post = new Post(['post_title' => 'test', 'post_parent' => 1]);
        $post->save();
        $this->assertContains($post->getAttribute('ID'), Post::with(['children'])->find(1)->children->pluck('ID'));
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
            $post->children()->save($child);
            $post = $child;
        }
        $this->assertEquals(1, $child->root()->getAttribute('ID'));

        $this->assertNull(Post::find(1)->root());
    }

    /**
     * @test
     */
    public function termsのテスト()
    {
        $post = Post::with(['terms', 'terms.term'])->find(1);
        $this->assertEquals('未分類', $post->terms->first()->term->getAttribute('name'));
    }

    /**
     * @test
     */
    public function categoriesのテスト()
    {
        $post = Post::with(['categories'])->find(1);
        $this->assertEquals('未分類', $post->categories->first()->term->getAttribute('name'));
        $term = new Term(['name'=>'テスト']);
        $term->save();
        $term_taxnomy = new TermTaxonomy(['taxonomy' => 'category']);
        $term->taxonomies()->save($term_taxnomy);
        $post->terms()->save($term_taxnomy);

        $post = Post::with(['categories.term'])->find(1);
        $this->assertEquals('テスト', $post->categories->pluck('term','term_id')->get($term->getAttribute('term_id'))->getAttribute('name'));
    }

    /**
     * @test
     */
    public function randのテスト()
    {
        try {
            $this->assertStringContainsString('order by RAND', Post::inRandomOrder()->toSql());
            $this->assertStringContainsString('order by RAND', User::inRandomOrder()->toSql());
        } catch(\Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }
}