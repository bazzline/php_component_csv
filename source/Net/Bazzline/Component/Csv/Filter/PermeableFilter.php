<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Filter;

use Net\Bazzline\Component\GenericAgreement\Exception\ExceptionInterface;

class PermeableFilter extends AbstractFilter
{
    /**
     * @param mixed $data
     * @return null|mixed
     * @throws ExceptionInterface
     */
    public function filter($data)
    {
        return $data;
    }
}