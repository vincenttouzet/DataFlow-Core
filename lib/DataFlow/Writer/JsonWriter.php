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

use Exporter\Source\JsonWriter as BaseJsonWriter;

class JsonWriter extends BaseJsonWriter implements WriterInterface
{
    use Writer;

    // body
}
