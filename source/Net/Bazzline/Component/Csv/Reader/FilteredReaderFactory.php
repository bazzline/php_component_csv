<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-24
 */

namespace Net\Bazzline\Component\Csv\Reader;

use Net\Bazzline\Component\Csv\Filter\AlwaysValidFilter;
use Net\Bazzline\Component\Csv\Filter\FilterInterface;

class FilteredReaderFactory extends ReaderFactory
{
    /**
     * @return FilteredReader
     */
    protected function getReader()
    {
        $reader = new FilteredReader();

        $reader->setFilter($this->getFilter());

        return $reader;
    }

    /**
     * @return FilterInterface
     */
    protected function getFilter()
    {
        return new AlwaysValidFilter();
    }
}