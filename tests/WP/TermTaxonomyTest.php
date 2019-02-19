<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-19
 * Time: 13:04
 */

namespace WeDevs\ORM\Test\WP;

use PHPUnit\Framework\TestCase;
use WeDevs\ORM\WP\Term\TermTaxonomy;

class TermTaxonomyTest extends TestCase
{
    /**
     * @test
     */
    public function テスト()
    {
        $taxonomy = TermTaxonomy::with(['posts', 'posts.terms.term'])->find(1);
        $this->assertEquals(1, $taxonomy->posts->first()->terms->first()->term->getAttribute('term_id'));
    }
}