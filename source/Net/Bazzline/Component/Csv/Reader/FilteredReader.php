<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Reader;

use Net\Bazzline\Component\GenericAgreement\Data\FilterableInterface;

class FilteredReader extends Reader
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
     * @param null|int $lineNumber - if "null", current line number is used
     * @return array|bool|string
     */
    public function readOne($lineNumber = null)
    {
        $data           = parent::readOne($lineNumber);
        $filteredData   = $this->filter->filter($data);

        if (is_null($filteredData)) {
            $filteredData = ($this->valid()) ? $this->readOne() : false;
        }

        return $filteredData;
    }
}