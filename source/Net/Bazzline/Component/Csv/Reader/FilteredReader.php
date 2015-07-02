<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-14 
 */

namespace Net\Bazzline\Component\Csv\Reader;

use Net\Bazzline\Component\Csv\Validator\ValidatorInterface;

class FilteredReader extends Reader
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
     * @param null|int $lineNumber - if "null", current line number is used
     * @return array|bool|string
     */
    public function readOne($lineNumber = null)
    {
        $content = parent::readOne($lineNumber);

        $isValidContent = $this->validator->isValid($content);

        if (!$isValidContent) {
            $content = ($this->valid()) ? $this->readOne() : false;
        }

        return $content;
    }
}