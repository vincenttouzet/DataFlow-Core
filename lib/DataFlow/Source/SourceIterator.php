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

use DataFlow\Filter\FilterContainer;
use DataFlow\Mapper\MapperContainer;

trait SourceIterator
{
    use MapperContainer;
    use FilterContainer;

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
                } else {
                    $mappedData[$key] = $value;
                }
            }
            $data = $mappedData;
        }

        return $data;
    }

    public function valid()
    {
        $valid = parent::valid();
        if ($valid && $filters = $this->getFilters()) {
            $data = $this->current();
            $ok = true;
            foreach ($filters as $filter) {
                $ok = $ok && call_user_func($filter, $data);
            }
            if (!$ok) {
                //skipping
                $this->next();
                if ($this->valid()) {
                    $this->current();
                } else {
                    $valid = false;
                }
            }
        }

        return $valid;
    }
}
