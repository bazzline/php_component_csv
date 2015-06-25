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
    /**
    public function readOne($lineNumber = null)
    {
echo __LINE__ . PHP_EOL;
        $content = parent::readOne($lineNumber);

        $isValidContent = $this->filter->isValid($content);

echo var_export($isValidContent, true) . PHP_EOL;

        if (!$isValidContent) {
            $content = parent::readOne();
        }

        return $content;
    }
     */

    /**
     * @return mixed
     */
    ///**
    public function current()
    {
        $data           = parent::current();
        $isValidData    = $this->filter->isValid($data);
echo 'isValidData: ' . var_export($isValidData, true) . PHP_EOL;

        if (!$isValidData) {
            $this->next();
            $data = ($this->valid()) ? $this->current() : null;
        }

        return $data;
    }
    //*/
}