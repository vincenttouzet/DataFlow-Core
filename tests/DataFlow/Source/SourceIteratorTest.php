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
        $mapper->addMapping('firstname', 'firstname');
        $mapper->addMapping('name', 'lastname');
        $this->source->setMapper($mapper);
        $i = 0;
        foreach ($this->source as $data) {
            $original = $this->data[$i]['username'];
            $this->assertEquals($original, $data['login']);
            $i++;
        }
    }
}
