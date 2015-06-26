<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-06 
 */

namespace Net\Bazzline\Component\Csv\Reader;

use Net\Bazzline\Component\Csv\AbstractFactory;
use Net\Bazzline\Component\Toolbox\HashMap\Combine;

class ReaderFactory extends AbstractFactory
{
    /**
     * @return object|Reader
     */
    public function create()
    {
        $reader = $this->getReader();

        $reader->setCombine($this->getCombine());
        $reader->setDelimiter($this->getDelimiter());
        $reader->setEnclosure($this->getEnclosure());
        $reader->setEscapeCharacter($this->getEscapeCharacter());

        return $reader;
    }

    /**
     * @return Combine
     */
    protected function getCombine()
    {
        return new Combine();
    }

    /**
     * @return Reader
     */
    protected function getReader()
    {
        return new Reader();
    }
}