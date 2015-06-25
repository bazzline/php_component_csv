<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Reader;

use Net\Bazzline\Component\Csv\Filter\FilterInterface;

class FilteredReader extends Reader
{
    /** @var FilterInterface */
    private $filter;

    /**
     * @param FilterInterface $filter
     */
    public function setFilter(FilterInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param null|int $lineNumber - if "null", current line number is used
     * @return array|bool|string
     */
    public function readOne($lineNumber = null)
    {
        $content = parent::readOne($lineNumber);

        $isValidContent = $this->filter->isValid($content);

        if (!$isValidContent) {
            $content = ($this->valid()) ? $this->readOne() : false;
        }

        return $content;
    }
}