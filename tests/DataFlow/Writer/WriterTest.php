<?php

/*
 * This file is part of the DataFlow package.
 *
 * (c) Vincent Touzet <vincent.touzet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFlow\Writer;

use DataFlow\Filter\EqualFilter;
use DataFlow\Mapper\Mapper;

class WriterTest extends \PHPUnit_Framework_TestCase
{
    /* @var InMemoryWriter $writer */
    protected $writer = null;
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
        $this->writer = new InMemoryWriter();
    }

    public function testMapper()
    {
        $mapper = new Mapper();
        $mapper->addMapping('username', 'login');
        $mapper->addMapping('name', 'lastname');
        $this->writer->setMapper($mapper);

        $this->writer->write($this->data[0]);
        $this->writer->write($this->data[1]);

        $mappedData = $this->writer->getElements();

        $this->assertEquals($this->data[0]['username'], $mappedData[0]['login']);
        $this->assertEquals($this->data[0]['firstname'], $mappedData[0]['firstname']);
        $this->assertEquals($this->data[0]['name'], $mappedData[0]['lastname']);
    }

    public function testUseFilter()
    {
        $filter = new EqualFilter('username', 'johndoe');
        $this->writer->addFilter($filter);

        $this->writer->write($this->data[0]);
        $this->writer->write($this->data[1]);

        $writedData = $this->writer->getElements();

        $this->assertEquals(1, count($writedData));
    }

    public function testUseFilterNone()
    {
        $filter = new EqualFilter('username', 'not_found');
        $this->writer->addFilter($filter);

        $this->writer->write($this->data[0]);
        $this->writer->write($this->data[1]);

        $writedData = $this->writer->getElements();

        $this->assertEquals(0, count($writedData));
    }
}
