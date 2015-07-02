<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Writer;

use Net\Bazzline\Component\GenericAgreement\Data\FilterableInterface;

class FilteredWriter extends Writer
{
    /** @var FilterableInterface */
    private $filter;

    /**
     * @param FilterableInterface $filter
     */
    public function setFilter(FilterableInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param array|mixed $filteredData
     * @return false|int
     */
    public function writeOne($filteredData)
    {
        $filteredData = $this->filter->filter($filteredData);

        return (!is_null($filteredData))
            ? parent::writeOne($filteredData) : false;
    }
}