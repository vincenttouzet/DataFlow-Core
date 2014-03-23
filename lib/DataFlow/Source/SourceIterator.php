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

use DataFlow\Mapper\MapperContainer;

trait SourceIterator
{
    use MapperContainer;

    /**
     * Override current of SourceIteratorInterface to retrieve mapped data
     *
     * @return array
     */
    public function current()
    {
        $data = parent::current();
        if ($this->getMapper()) {
            $mappedData = array();
            foreach ($data as $key => $value) {
                if ($index = $this->getMapper()->getMapping($key)) {
                    $mappedData[$index] = $value;
                }
            }
            $data = $mappedData;
        }

        return $data;
    }
}
