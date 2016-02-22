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
     * @param array|mixed $data
     * @return false|int
     */
    public function writeOne($data)
    {
        $filteredData = $this->filter->filter($data);

        return (!is_null($filteredData))
            ? parent::writeOne($filteredData) : false;
    }
}