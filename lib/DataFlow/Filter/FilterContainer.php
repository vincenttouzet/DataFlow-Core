<?php

/*
 * This file is part of the DataFlow package.
 *
 * (c) Vincent Touzet <vincent.touzet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFlow\Filter;

use Doctrine\Common\Collections\ArrayCollection;

trait FilterContainer
{
    protected $filters = null;

    /**
     * @param callable $filter
     */
    public function addFilter(callable $filter)
    {
        if (is_null($this->filters)) {
            $this->filters = new ArrayCollection();
        }
        $this->filters->add($filter);
    }

    /**
     * @return ArrayCollection|null
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
