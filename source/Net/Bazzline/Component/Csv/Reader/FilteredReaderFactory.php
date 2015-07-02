<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-24
 */

namespace Net\Bazzline\Component\Csv\Reader;

use Net\Bazzline\Component\Csv\Filter\PermeableFilter;
use Net\Bazzline\Component\GenericAgreement\Data\FilterableInterface;

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
     * @return FilterableInterface
     */
    protected function getFilter()
    {
        return new PermeableFilter();
    }
}