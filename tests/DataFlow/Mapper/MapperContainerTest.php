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

class MapperContainerTest extends \PHPUnit_Framework_TestCase
{
    use MapperContainer;

    public function testUsage()
    {
        $this->assertEquals(null, $this->getMapper());
        $mapper = new Mapper();
        $mapper->addMapping('foo', 'bar');
        $this->setMapper($mapper);
        $this->assertEquals('bar', $this->getMapper()->getMapping('foo'));
    }
}
