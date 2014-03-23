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

interface MapperInterface
{
    /**
     * @param string $name
     * @param string $map
     */
    public function addMapping($name, $map);

    /**
     * @param string $name
     */
    public function hasMapping($name);

    /**
     * @param $name
     * @return mixed
     */
    public function getMapping($name);
}
