<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-02 
 */

namespace Net\Bazzline\Component\Csv\Filter;

use Net\Bazzline\Component\GenericAgreement\Data\FilterableInterface;
use Net\Bazzline\Component\GenericAgreement\Exception\ExceptionInterface;

abstract class AbstractFilter implements FilterableInterface
{
    /**
     * @param mixed $data
     * @return null|mixed
     * @throws ExceptionInterface
     */
    public function __invoke($data)
    {
        return $this->filter($data);
    }
}