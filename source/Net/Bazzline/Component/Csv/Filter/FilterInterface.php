<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Filter;

interface FilterInterface
{
    /**
     * @param $data
     * @return boolean
     */
    public function isValid($data);
}