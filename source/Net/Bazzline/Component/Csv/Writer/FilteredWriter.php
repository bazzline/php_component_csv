<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Writer;

use Net\Bazzline\Component\Csv\Validator\ValidatorInterface;

class FilteredWriter extends Writer
{
    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array|mixed $data
     * @return false|int
     */
    public function writeOne($data)
    {
        return ($this->validator->isValid($data))
            ? parent::writeOne($data) : false;
    }
}