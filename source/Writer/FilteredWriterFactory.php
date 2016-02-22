<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Writer;

use Net\Bazzline\Component\Csv\Filter\PermeableFilter;
use Net\Bazzline\Component\GenericAgreement\Data\FilterableInterface;

class FilteredWriterFactory extends WriterFactory
{
    /**
     * @return FilteredWriter|FilteredWriterForPhp3Dot3
     */
    protected function getWriter()
    {
        if ($this->phpVersionLessThen5Dot4()) {
            $writer = new FilteredWriterForPhp3Dot3();
        } else {
            $writer = new FilteredWriter();
        }

        $writer->setFilter($this->getFilter());

        return $writer;
    }

    /**
     * @return FilterableInterface
     */
    protected function getFilter()
    {
        return new PermeableFilter();
    }
}