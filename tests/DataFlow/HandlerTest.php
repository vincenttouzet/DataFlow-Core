<?php

/*
 * This file is part of the DataFlow package.
 *
 * (c) Vincent Touzet <vincent.touzet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFlow;

use DataFlow\Source\ArraySourceIterator;
use DataFlow\Writer\InMemoryWriter;

class HandlerTest extends \PHPUnit_Framework_TestCase
{
    /* @var Handler $handler */
    protected $handler = null;

    /* @var ArraySourceIterator $source1 */
    protected $source1 = null;
    /* @var ArraySourceIterator $source2 */
    protected $source2 = null;

    /* @var InMemoryWriter $writer1 */
    protected $writer1 = null;
    /* @var InMemoryWriter $writer2 */
    protected $writer2 = null;

    protected $data1 = array(
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

    protected $data2 = array(
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
    );

    public function setUp()
    {
        $this->source1 = new ArraySourceIterator($this->data1);
        $this->source2 = new ArraySourceIterator($this->data2);

        $this->writer1 = new InMemoryWriter();
        $this->writer2 = new InMemoryWriter();

        $this->handler = new Handler();
        $this->handler->addSource($this->source1);
        $this->handler->addSource($this->source2);
        $this->handler->addWriter($this->writer1);
        $this->handler->addWriter($this->writer2);
    }

    public function testAggregateAndExport()
    {
        $this->assertEquals(0, count($this->writer1->getElements()));
        $this->assertEquals(0, count($this->writer2->getElements()));

        $this->handler->aggregateAndExport();

        $this->assertEquals(4, count($this->writer1->getElements()));
        $this->assertEquals(4, count($this->writer2->getElements()));
    }

    public function testMergeAndExport()
    {
        $this->assertEquals(0, count($this->writer1->getElements()));
        $this->assertEquals(0, count($this->writer2->getElements()));

        $this->handler->mergeAndExport('username');

        $this->assertEquals(3, count($this->writer1->getElements()));
        $this->assertEquals(3, count($this->writer2->getElements()));
    }
}
