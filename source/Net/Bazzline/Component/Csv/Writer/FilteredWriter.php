<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Writer;

use Net\Bazzline\Component\Csv\Filter\FilterInterface;

class FilteredWriter extends Writer
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
     * @param array|mixed $data
     * @return false|int
     */
    public function writeOne($data)
    {
        return ($this->filter->isValid($data))
            ? parent::writeOne($data) : false;
    }
}