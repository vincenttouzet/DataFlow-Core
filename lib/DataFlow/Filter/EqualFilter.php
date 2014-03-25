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

class EqualFilter
{
    protected $key = null;
    protected $value = null;

    /**
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function __invoke(array $data)
    {
        return isset($data[$this->key]) && $data[$this->key] == $this->value;
    }
}
