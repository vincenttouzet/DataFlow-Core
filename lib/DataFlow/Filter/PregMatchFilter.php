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

class PregMatchFilter
{
    protected $key = null;
    protected $pattern = null;

    /**
     * @param $key
     * @param $pattern
     */
    public function __construct($key, $pattern)
    {
        $this->key = $key;
        $this->pattern = $pattern;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function __invoke(array $data)
    {
        return isset($data[$this->key]) && preg_match($this->pattern, $data[$this->key]);
    }
}
