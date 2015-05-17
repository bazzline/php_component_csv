<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-06 
 */

namespace Net\Bazzline\Component\Csv;

abstract class AbstractFactory implements FactoryInterface
{
    /**
     * @return string
     */
    protected function getDelimiter()
    {
        return ',';
    }

    /**
     * @return string
     */
    protected function getEnclosure()
    {
        return '"';
    }

    /**
     * @return string
     */
    protected function getEscapeCharacter()
    {
        return "\\";
    }
}