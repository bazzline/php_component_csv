<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-16 
 */

namespace Net\Bazzline\Component\Csv\Reader;

class EasyCsvReaderAdapter
{
    /** @var Reader */
    private $reader;

    /**
     * @param string $path
     * @param string $mode - not in use
     * @param bool $headersInFirstRow
     * @param Reader $reader - optional
     */
    public function __construct($path, $mode = 'r+', $headersInFirstRow = true, Reader $reader = null)
    {
        if (is_null($reader)) {
            $factory = new ReaderFactory();
            $this->reader = $factory->create();
        } else {
            $this->reader = $reader;
        }

        $this->reader->setDelimiter(',');
        $this->reader->setEnclosure('"');
        $this->reader->setPath($path);

        if ($headersInFirstRow) {
            $this->reader->enableHasHeadline();
        } else {
            $this->reader->disableHasHeadline();
        }
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->reader->setDelimiter($delimiter);
    }

    /**
     * @param string $enclosure
     */
    public function setEnclosure($enclosure)
    {
        $this->reader->setEnclosure($enclosure);
    }

    /**
     * @return array|false
     */
    public function getHeaders()
    {
        return $this->reader->readHeadline();
    }

    /**
     * @return array|bool|string
     */
    public function getRow()
    {
        return $this->reader->readOne();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->reader->readAll();
    }

    /**
     * @return int|null
     */
    public function getLineNumber()
    {
        return $this->reader->key();
    }
}