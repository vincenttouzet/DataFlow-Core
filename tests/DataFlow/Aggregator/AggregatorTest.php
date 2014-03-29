<?php

/*
 * This file is part of the DataFlow package.
 *
 * (c) Vincent Touzet <vincent.touzet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFlow\Aggregator;

use DataFlow\Source\ArraySourceIterator;
use DataFlow\Writer\InMemoryWriter;

class AggregatorTest extends \PHPUnit_Framework_TestCase
{
    /* @var Aggregator $aggregator */
    protected $aggregator = null;
    /* @var InMemoryWriter $writer */
    protected $writer = null;

    public function setUp()
    {
        $source1 = new ArraySourceIterator(
            array(
                array(
                    'username' => 'johndoe',
                    'firstname' => 'John 1',
                    'name' => '',
                    'email' => 'johndoe@domain.com',
                ),
                array(
                    'username' => 'johndoe_2',
                    'firstname' => 'John 2',
                    'name' => 'Doe',
                    'email' => 'email@example.com',
                ),
            )
        );
        $source2 = new ArraySourceIterator(
            array(
                array(
                    'username' => 'johndoe_2',
                    'email' => 'email@example.com',
                    'age' => '42',
                    'firstname' => 'John 2.1',
                    'name' => '',
                ),
                array(
                    'username' => 'johndoe',
                    'email' => 'johndoe@domain.com',
                    'age' => '25',
                    'firstname' => 'John 1.1',
                    'name' => 'Doe',
                ),
            )
        );
        $this->writer = new InMemoryWriter();
        $this->aggregator = new Aggregator(array($source1), $this->writer);
        $this->aggregator->addSource($source2);
    }

    public function testAggregate()
    {
        $this->assertEquals(0, count($this->writer->getElements()));
        $this->aggregator->aggregate();
        $this->assertEquals(4, count($this->writer->getElements()));
        $this->assertEquals(4, count($this->aggregator->getWriter()->getElements()));
    }

    public function testMerge()
    {
        $this->aggregator->merge('username');
        $merged = $this->writer->getElements();
        $this->assertEquals(2, count($merged));
        // test values
        $this->assertEquals('johndoe', $merged[0]['username']);
        $this->assertEquals('johndoe@domain.com', $merged[0]['email']);
        $this->assertEquals('John 1.1', $merged[0]['firstname']);
        $this->assertEquals('Doe', $merged[0]['name']);
        $this->assertEquals('25', $merged[0]['age']);

        $this->assertEquals('johndoe_2', $merged[1]['username']);
        $this->assertEquals('email@example.com', $merged[1]['email']);
        $this->assertEquals('John 2.1', $merged[1]['firstname']);
        $this->assertEquals('Doe', $merged[1]['name']);
        $this->assertEquals('42', $merged[1]['age']);
    }

    public function testGetGetAggregatedHeaders()
    {
        $this->aggregator->addSource(new ArraySourceIterator(array(array('username'=>'jojo'))));
        $headers = $this->aggregator->getAggregateHeaders();
        $this->assertTrue(in_array('username', $headers));
        $this->assertTrue(in_array('firstname', $headers));
        $this->assertTrue(in_array('name', $headers));
        $this->assertTrue(in_array('email', $headers));
        $this->assertTrue(in_array('age', $headers));
    }

    public function testSetDefaultValues()
    {
        $this->aggregator->setDefaultValues(array('age' => '-', 'name' => '-'));
        $this->aggregator->aggregate();
        $elements = $this->writer->getElements();
        $this->assertEquals('-', $elements[0]['age']);
        $this->assertEquals('-', $elements[1]['age']);
        $this->assertEquals('-', $elements[2]['name']);
    }
}
