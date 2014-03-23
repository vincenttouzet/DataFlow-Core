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

use DataFlow\Source\SourceIteratorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use DataFlow\Writer\WriterInterface;

class Aggregator
{
    /* @var ArrayCollection $sources */
    protected $sources = null;
    /* @var WriterInterface $writer */
    protected $writer = null;

    protected $defaultValues = null;

    /**
     * @param array           $sources
     * @param WriterInterface $writer
     */
    public function __construct(array $sources, WriterInterface $writer)
    {
        $this->sources = new ArrayCollection($sources);
        $this->writer = $writer;
    }

    public function addSource(SourceIteratorInterface $source)
    {
        $this->sources->add($source);
    }

    /**
     * Aggregate data from multiple sources
     *
     * @return WriterInterface
     */
    public function aggregate()
    {
        $defaultValues = $this->getDefaultValues();
        $this->writer->open();
        foreach ($this->sources as $source) {
            foreach ($source as $data) {
                $data = array_merge($defaultValues, $data);
                $this->writer->write($data);
            }
        }
        $this->writer->close();

        return $this->writer;
    }

    /**
     * Merge data from multiple source
     *
     * @param string $primary
     *
     * @return WriterInterface
     */
    public function merge($primary)
    {
        $mergedData = array();
        $defaultValues = $this->getDefaultValues();
        foreach ($this->sources as $source) {
            foreach ($source as $data) {
                $data = array_merge($defaultValues, $data);
                $identifier = $data[$primary];
                if (isset($mergedData[$identifier])) {
                    $mergedData[$identifier] = array_merge(
                        $mergedData[$identifier],
                        $data
                    );
                } else {
                    $mergedData[$identifier] = $data;
                }
            }
        }
        $this->writer->open();
        foreach ($mergedData as $data) {
            $this->writer->write($data);
        }
        $this->writer->close();

        return $this->writer;
    }

    /**
     * Get the aggregated headers from all sources
     *
     * @return array
     */
    public function getAggregateHeaders()
    {
        $aggregatedHeaders = array();
        foreach ($this->sources as $source) {
            $source->rewind();
            $source->next();
            $headers = $source->current();
            $headers = array_flip($headers);
            $aggregatedHeaders = array_merge($aggregatedHeaders, $headers);
        }

        return $aggregatedHeaders;
    }

    /**
     * @param null $defaultValues
     */
    public function setDefaultValues($defaultValues)
    {
        $generatedDefaultValues = $this->generateDefaultValues();
        foreach ($defaultValues as $key => $value) {
            $generatedDefaultValues[$key] = $value;
        }
        $this->defaultValues = $generatedDefaultValues;
    }

    /**
     * @return null
     */
    public function getDefaultValues()
    {
        if (is_null($this->defaultValues)) {
            $this->defaultValues = $this->generateDefaultValues();
        }

        return $this->defaultValues;
    }

    protected function generateDefaultValues()
    {
        $headers = $this->getAggregateHeaders();
        $defaultValues = array();
        foreach ($headers as $header) {
            $defaultValues[$header] = '';
        }

        return $defaultValues;
    }

    /**
     * @return WriterInterface
     */
    public function getWriter()
    {
        return $this->writer;
    }
}