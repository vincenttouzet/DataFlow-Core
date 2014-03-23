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
                    'name' => 'Doe',
                ),
                array(
                    'username' => 'johndoe_2',
                    'firstname' => 'John 2',
                    'name' => 'Doe',
                ),
            )
        );
        $source2 = new ArraySourceIterator(
            array(
                array(
                    'username' => 'johndoe',
                    'email' => 'johndoe@domain.com',
                    'age' => '25',
                ),
                array(
                    'username' => 'johndoe3',
                    'email' => 'email@example.com',
                    'age' => '42',
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
        $this->assertEquals(3, count($merged));
        $this->assertEquals('johndoe@domain.com', $merged[0]['email']);
    }

    public function getGetAggregatedHeaders()
    {
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
        $this->assertEquals('-', $elements[3]['name']);
    }
}
