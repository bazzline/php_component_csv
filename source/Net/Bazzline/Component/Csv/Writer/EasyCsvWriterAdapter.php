<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-16 
 */

namespace Net\Bazzline\Component\Csv\Writer;

class EasyCsvWriterAdapter
{
    /** @var Writer|WriterForPhp5Dot3  */
    private $writer;

    /**
     * @param string $path
     * @param string $mode - is not used
     * @param null|Writer $writer - optional
     */
    public function __construct($path, $mode = 'r+', Writer $writer = null)
    {
        if (is_null($writer)) {
            $factory = new WriterFactory();
            $this->writer = $factory->create();
        } else {
            $this->writer = $writer;
        }

        $this->writer->setDelimiter(',');
        $this->writer->setEnclosure('"');
        $this->writer->setPath($path);
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->writer->setDelimiter($delimiter);
    }

    /**
     * @param string $enclosure
     */
    public function setEnclosure($enclosure)
    {
        $this->writer->setEnclosure($enclosure);
    }

    /**
     * @param mixed $row
     * @return false|int
     */
    public function writeRow($row)
    {
        return $this->writer->writeOne($row);
    }

    /**
     * @param array $array
     */
    public function writeFromArray(array $array)
    {
        $this->writer->writeMany($array);
    }
}