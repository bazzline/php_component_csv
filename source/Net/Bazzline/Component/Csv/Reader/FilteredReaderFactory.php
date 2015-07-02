<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-24
 */

namespace Net\Bazzline\Component\Csv\Reader;

use Net\Bazzline\Component\Csv\Validator\AlwaysValidValidator;
use Net\Bazzline\Component\Csv\Validator\ValidatorInterface;

class FilteredReaderFactory extends ReaderFactory
{
    /**
     * @return FilteredReader
     */
    protected function getReader()
    {
        $reader = new FilteredReader();

        $reader->setValidator($this->getValidator());

        return $reader;
    }

    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return new AlwaysValidValidator();
    }
}