<?php

/*
 * This file is part of the DataFlow package.
 *
 * (c) Vincent Touzet <vincent.touzet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFlow\Filter;

class PregMatchFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $filter = new PregMatchFilter('username', '/^vincent/');

        $this->assertTrue(call_user_func($filter, array('username' => 'vincenttouzet')));
        $this->assertTrue(call_user_func($filter, array('username' => 'vincent.touzet')));
        $this->assertTrue(call_user_func($filter, array('username' => 'vincent_touzet')));
        $this->assertFalse(call_user_func($filter, array('username' => 'johndoe')));
        $this->assertFalse(call_user_func($filter, array('login' => 'vincenttouzet')));
        $this->assertFalse(call_user_func($filter, array('login' => 'johndoe')));
    }
}
