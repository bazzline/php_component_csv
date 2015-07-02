<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Writer;

use Net\Bazzline\Component\Csv\Validator\AlwaysValidValidator;
use Net\Bazzline\Component\Csv\Validator\ValidatorInterface;

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

        $writer->setValidator($this->getValidator());

        return $writer;
    }

    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return new AlwaysValidValidator();
    }
}