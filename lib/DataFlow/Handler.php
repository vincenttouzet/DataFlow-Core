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

use DataFlow\Aggregator\Aggregator;
use DataFlow\Source\CsvSourceIterator;
use DataFlow\Writer\CsvWriter;
use Doctrine\Common\Collections\ArrayCollection;
use DataFlow\Source\SourceIteratorInterface;
use DataFlow\Writer\WriterInterface;

class Handler
{
    /* @var ArrayCollection $sources */
    protected $sources = array();
    /* @var ArrayCollection $writers */
    protected $writers = array();

    /* @var Aggregator $aggregator */
    protected $aggregator = null;

    protected $tempName = null;

    /**
     * @param array $sources
     * @param array $writers
     */
    public function __construct(array $sources = array(), array $writers = array())
    {
        $this->sources = new ArrayCollection($sources);
        $this->writers = new ArrayCollection($writers);
    }

    /**
     * @param SourceIteratorInterface $source
     *
     * @return $this
     */
    public function addSource(SourceIteratorInterface $source)
    {
        $this->sources->add($source);

        return $this;
    }

    /**
     * @param WriterInterface $writer
     *
     * @return $this
     */
    public function addWriter(WriterInterface $writer)
    {
        $this->writers->add($writer);

        return $this;
    }

    /**
     * Aggregate sources and export to writers
     */
    public function aggregateAndExport()
    {
        $this->prepareAggregator();
        $this->aggregator->aggregate();
        $this->export();
    }

    /**
     * Merge data from multiple sources and export to writers
     *
     * @param string $primary
     */
    public function mergeAndExport($primary)
    {
        $this->prepareAggregator();
        $this->aggregator->merge($primary);
        $this->export();
    }

    /**
     * Prepare aggregator
     */
    protected function prepareAggregator()
    {
        $this->aggregator = new Aggregator(
            $this->sources->toArray(),
            new CsvWriter($this->getTempName())
        );
    }

    /**
     * Export data
     */
    protected function export()
    {
        $source = new CsvSourceIterator($this->getTempName());
        foreach ($this->writers as $writer) {
            $writer->open();
        }
        foreach ($source as $data) {
            foreach ($this->writers as $writer) {
                $writer->write($data);
            }
        }
        foreach ($this->writers as $writer) {
            $writer->close();
        }
        unlink($this->getTempName());
    }

    /**
     * Get the temp filename
     *
     * @return string
     */
    protected function getTempName()
    {
        if (is_null($this->tempName)) {
            $this->tempName = tempnam(sys_get_temp_dir(), uniqid());
            unlink($this->tempName);
        }

        return $this->tempName;
    }
}
