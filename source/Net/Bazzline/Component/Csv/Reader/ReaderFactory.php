<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-06 
 */

namespace Net\Bazzline\Component\Csv\Reader;

use Net\Bazzline\Component\Csv\AbstractFactory;

class ReaderFactory extends AbstractFactory
{
    /**
     * @return object|Reader
     */
    public function create()
    {
        $reader = new Reader();

        $reader->setDelimiter($this->getDelimiter());
        $reader->setEnclosure($this->getEnclosure());
        $reader->setEscapeCharacter($this->getEscapeCharacter());

        return $reader;
    }
}