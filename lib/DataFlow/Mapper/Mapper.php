<?php

/*
 * This file is part of the DataFlow package.
 *
 * (c) Vincent Touzet <vincent.touzet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFlow\Mapper;

class Mapper implements MapperInterface
{
    private $mappings = array();

    /**
     * @param string $name
     * @param string $map
     */
    public function addMapping($name, $map)
    {
        $this->mappings[$name] = $map;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function hasMapping($name)
    {
        return isset($this->mappings[$name]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getMapping($name)
    {
        if ($this->hasMapping($name)) {
            return $this->mappings[$name];
        }

        return null;
    }
}
