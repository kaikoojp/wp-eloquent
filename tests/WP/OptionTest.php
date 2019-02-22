<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-21
 * Time: 16:14
 */

namespace WeDevs\ORM\Test\WP;


use PHPUnit\Framework\TestCase;
use WeDevs\ORM\WP\Option;

class OptionTest extends TestCase
{
    /**
     * @test
     */
    public function 取得テスト()
    {
        $this->assertEquals([], Option::get('active_plugins'));
        $this->assertEquals('hogehogehoge', Option::get('hogehogehoge', 'hogehogehoge'));
    }

    /**
     * @test
     */
    public function 保存と上書きテスト()
    {
        Option::set('test', 'test');
        $this->assertEquals('test', Option::get('test'));
        $this->assertTrue(Option::set('test', 'test2'));
        $this->assertEquals('test2', Option::get('test'));
        $this->assertTrue(Option::set('test', [1, 2, 3]));
        $this->assertEquals([1, 2, 3], Option::get('test'));
    }

    /**
     * @test
     */
    public function 削除テスト()
    {
        $this->assertTrue(Option::delete('test'));
        $this->assertFalse(Option::delete('test'));
    }
}
