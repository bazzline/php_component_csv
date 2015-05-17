<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace Net\Bazzline\Component\Csv\Writer;

use Net\Bazzline\Component\BatchJob\RuntimeException;
use Net\Bazzline\Component\Csv\AbstractBase;
use Net\Bazzline\Component\Csv\InvalidArgumentException;

class Writer extends AbstractBase
{
    const OPEN_MODE_APPEND      = 'a';
    const OPEN_MODE_TRUNCATE    = 'w';

    /** @var boolean */
    private $useTruncateAsOpenMode = false;

    /**
     * @param mixed|array $data
     * @return false|int
     */
    public function __invoke($data)
    {
        return $this->writeOne($data);
    }


    //begin of general
    /**
     * @param string $path
     * @param bool $setPathAsCurrentPath
     * @return bool
     * @throws InvalidArgumentException
     * @todo implement validation
     */
    public function copy($path, $setPathAsCurrentPath = false)
    {
        $couldBeCopied = copy($this->getPath(), $path);

        if ($setPathAsCurrentPath) {
            if ($couldBeCopied) {
                $this->close();
                $this->setPath($path);
            }
        }

        return $couldBeCopied;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $this->close();

        return unlink($this->getPath());
    }

    public function truncate()
    {
        $this->close();
        $this->useTruncateAsOpenMode = true;
        $this->open($this->getPath());
        $this->useTruncateAsOpenMode = false;
    }

    /**
     * truncates file and writes content
     *
     * @param array $collection
     * @return false|int
     */
    public function writeAll(array $collection)
    {
        $this->truncate();

        return $this->writeMany($collection);
    }

    /**
     * @param array $headlines
     * @return false|int
     */
    public function writeHeadlines(array $headlines)
    {
        $this->setHeadline($headlines);

        return $this->writeOne($headlines);
    }

    /**
     * @param array $collection
     * @return false|int
     */
    public function writeMany(array $collection)
    {
        $lengthOfTheWrittenStrings = 0;

        foreach ($collection as $data) {
            $lengthOfTheWrittenString = $this->writeOne($data);

            if ($lengthOfTheWrittenString === false) {
                $lengthOfTheWrittenStrings = $lengthOfTheWrittenString;
                break;
            } else {
                $lengthOfTheWrittenStrings += $lengthOfTheWrittenString;
            }
        }

        return $lengthOfTheWrittenStrings;
    }

    /**
     * @param string|array $data
     * @return false|int
     */
    public function writeOne($data)
    {
        if (!is_array($data)) {
            $data = explode($this->getDelimiter(), $data);
            $data = array_map(function($value) {
                return trim($value);
            }, $data);
        }

        return $this->getFileHandler()->fputcsv($data, $this->getDelimiter(), $this->getEnclosure());
    }
    //end of general

    /**
     * @return string
     */
    protected function getFileHandlerOpenMode()
    {
        return ($this->useTruncateAsOpenMode) ? self::OPEN_MODE_TRUNCATE : self::OPEN_MODE_APPEND;
    }
}