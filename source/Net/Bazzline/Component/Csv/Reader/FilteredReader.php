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
     * @return mixed
     */
    public function current()
    {
        $data = parent::current();

        if (!$this->filter->isValid($data)) {
            $this->next();
            $data = $this->current();
        }

        return $data;
    }
}