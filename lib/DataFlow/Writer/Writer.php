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

use DataFlow\Filter\FilterContainer;
use DataFlow\Mapper\MapperContainer;

trait Writer
{
    use MapperContainer;
    use FilterContainer;

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
                } else {
                    $mappedData[$key] = $data[$key];
                }
            }
            $data = $mappedData;
        }
        if ($filters = $this->getFilters()) {
            $ok = true;
            foreach ($filters as $filter) {
                $ok = $ok && call_user_func($filter, $data);
            }
            if (!$ok) {
                return;
            }
        }
        parent::write($data);
    }
}
