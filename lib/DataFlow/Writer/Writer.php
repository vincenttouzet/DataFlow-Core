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

use DataFlow\Mapper\MapperContainer;

trait Writer
{
    use MapperContainer;

    /**
     * Override write of WriterInterface to export data with mapping
     *
     * @param array $data
     */
    public function write(array $data)
    {
        if ($this->getMapper()) {
            $mappedData = array();
            foreach ($data as $key => $value) {
                if ($index = $this->getMapper()->getMapping($key)) {
                    $mappedData[$index] = $data[$key];
                }
            }
            $data = $mappedData;
        }
        parent::write($data);
    }
}
