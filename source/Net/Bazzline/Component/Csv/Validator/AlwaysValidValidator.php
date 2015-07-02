<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Validator;

class AlwaysValidValidator implements ValidatorInterface
{
    /**
     * @param $data
     * @return boolean
     */
    public function isValid($data)
    {
        return true;
    }
}