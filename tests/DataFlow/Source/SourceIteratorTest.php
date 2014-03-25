<?php

/*
 * This file is part of the DataFlow package.
 *
 * (c) Vincent Touzet <vincent.touzet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFlow\Source;

use DataFlow\Filter\EqualFilter;
use DataFlow\Mapper\Mapper;

class SourceIteratorTest extends \PHPUnit_Framework_TestCase
{
    /* @var ArraySourceIterator $source */
    protected $source = null;

    protected $data = array();

    public function setUp()
    {
        $this->data = array(
            array(
                'username' => 'johndoe',
                'firstname' => 'John 1',
                'name' => 'Doe',
            ),
            array(
                'username' => 'johndoe_2',
                'firstname' => 'John 2',
                'name' => 'Doe',
            ),
        );
        $this->source = new ArraySourceIterator($this->data);
    }

    public function testUseMapper()
    {
        $mapper = new Mapper();
        $mapper->addMapping('username', 'login');
        $mapper->addMapping('name', 'lastname');
        $this->source->setMapper($mapper);
        $i = 0;
        foreach ($this->source as $data) {
            $original = $this->data[$i];
            $this->assertEquals($original['username'], $data['login']);
            $this->assertEquals($original['firstname'], $data['firstname']);
            $this->assertEquals($original['name'], $data['lastname']);
            $i++;
        }
    }

    public function testUseFilter()
    {
        // just keep when username equals johndoe_2
        $filter = new EqualFilter('username', 'johndoe_2');
        $this->source->addFilter($filter);
        $i = 0;
        foreach ($this->source as $data) {
            $i++;
        }
        $this->assertEquals(1, $i);
    }

    public function testUseFilterOnLast()
    {
        $filter = new EqualFilter('username', 'johndoe');
        $this->source->addFilter($filter);
        $i = 0;
        foreach ($this->source as $data) {
            $i++;
        }
        $this->assertEquals(1, $i);
    }

    public function testUseFilterNone()
    {
        $filter = new EqualFilter('username', 'not_found');
        $this->source->addFilter($filter);
        $i = 0;
        foreach ($this->source as $data) {
            $i++;
        }
        $this->assertEquals(0, $i);
    }
}
