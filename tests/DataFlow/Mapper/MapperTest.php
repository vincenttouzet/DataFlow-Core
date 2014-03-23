<?php

/*
 * This file is part of the DataFlow package.
 *
 * (c) Vincent Touzet <vincent.touzet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFlow\Mapper;

class MapperTest extends \PHPUnit_Framework_TestCase
{
    public function testUsage()
    {
        $mapper = new Mapper();
        $this->assertFalse($mapper->hasMapping('column'));
        $mapper->addMapping('column', 'out_column');
        $this->assertTrue($mapper->hasMapping('column'));
        $this->assertEquals('out_column', $mapper->getMapping('column'));
        $this->assertEquals(null, $mapper->getMapping('not_found'));
    }
}
