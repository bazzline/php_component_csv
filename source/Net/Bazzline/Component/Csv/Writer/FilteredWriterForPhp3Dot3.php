<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Writer;

use Net\Bazzline\Component\Csv\Filter\FilterInterface;

class FilteredWriterForPhp3Dot3 extends WriterForPhp5Dot3
{
    /** @var FilterInterface */
    private $validator;

    /**
     * @param FilterInterface $validator
     */
    public function setValidator(FilterInterface $validator)
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