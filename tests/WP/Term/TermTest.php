<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-19
 * Time: 15:53
 */

namespace WeDevs\ORM\Test\WP\Term;

use PHPUnit\Framework\TestCase;
use WeDevs\ORM\WP\Term\Term;

class TermTest extends TestCase
{
    /**
     * @test
     */
    public function テスト()
    {
        $term = Term::taxonomy('未分類', 'category');
        $this->assertEquals('未分類', $term->getAttribute('name'));
        $this->assertEquals('category', $term->taxonomies->first()->getAttribute('taxonomy'));
    }
}