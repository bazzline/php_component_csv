<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-05-13
 */

namespace Net\Bazzline\Component\Csv\Writer;

/**
 * Class WriterForPhp5Dot3
 * @package Net\Bazzline\Component\Csv\Writer
 */
class WriterForPhp5Dot3 extends Writer
{
    public function __destruct()
    {
        $this->close();
    }

    /**
     * @param mixed|array $data
     * @return false|int
     */
    public function writeOne($data)
    {
        $data = $this->convertToArrayIfNeeded($data);

        return fputcsv($this->getFileHandler(), $data, $this->getDelimiter(), $this->getEnclosure());
    }

    /**
     * @param string $path
     * @return resource
     */
    protected function open($path)
    {
        $fileHandler = fopen($path, $this->getFileHandlerOpenMode());

        return $fileHandler;
    }
}