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

class FilterContainerTest extends \PHPUnit_Framework_TestCase
{
    use FilterContainer;

    public function testUsage()
    {
        $filter = new EqualFilter('key', 'value');
        $this->assertNull($this->getFilters());
        $this->addFilter($filter);
        $this->assertEquals(1, count($this->getFilters()));
        $this->addFilter(
            function (array $data) {
                return true;
            }
        );
        $this->assertEquals(2, count($this->getFilters()));
    }
}
