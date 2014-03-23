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

use Exporter\Source\CsvSourceIterator as Base;

class CsvSourceIterator extends Base implements SourceIteratorInterface
{
    use SourceIterator;

    // body
}
