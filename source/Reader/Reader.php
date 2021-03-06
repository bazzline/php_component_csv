<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2015-04-17
 */

namespace Net\Bazzline\Component\Csv\Reader;

//@see https://github.com/ajgarlag/AjglCsv/blob/master/Reader/ReaderAbstract.php
//@see https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Reader.php
//@todo implement save version to call enable/disable headline before setDelimiter etc.
use Net\Bazzline\Component\Csv\AbstractBase;
use Net\Bazzline\Component\Csv\InvalidArgumentException;
use Net\Bazzline\Component\Toolbox\HashMap\Combine;
use SplFileObject;

class Reader extends AbstractBase implements ReaderInterface
{
    /** @var bool */
    private $addHeadlineToOutput = true;

    /** @var Combine */
    private $combine;

    /** @var int */
    private $initialLineNumber = 0;

    /**
     * @param null $currentLineNumber
     * @return array|bool|string
     */
    public function __invoke($currentLineNumber = null)
    {
        return $this->readOne($currentLineNumber);
    }

    //begin of AbstractBase
    /**
     * @param string $delimiter
     * @throws InvalidArgumentException
     */
    public function setDelimiter($delimiter)
    {
        parent::setDelimiter($delimiter);
        if ($this->hasHeadline()) {
            $this->enableHasHeadline();
        }
    }

    /**
     * @param string $enclosure
     * @throws InvalidArgumentException
     */
    public function setEnclosure($enclosure)
    {
        parent::setEnclosure($enclosure);
        if ($this->hasHeadline()) {
            $this->enableHasHeadline();
        }
    }

    /**
     * @param string $escapeCharacter
     * @throws InvalidArgumentException
     */
    public function setEscapeCharacter($escapeCharacter)
    {
        parent::setEscapeCharacter($escapeCharacter);
        if ($this->hasHeadline()) {
            $this->enableHasHeadline();
        }
    }

    //end of AbstractBase

    //begin of Iterator
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->getFileHandler()->current();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->getFileHandler()->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->getFileHandler()->key();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->getFileHandler()->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        if ($this->hasHeadline()) {
            $this->updateHeadline();
            $lineNumber = 1;
        } else {
            $lineNumber = 0;
        }
        $this->initialLineNumber = $lineNumber;
        $this->seekFileToCurrentLineNumberIfNeeded(
            $this->getFileHandler(),
            $lineNumber
        );
    }
    //end of Iterator

    //begin of headlines
    /**
     * @return $this
     */
    public function disableAddHeadlineToOutput()
    {
        $this->addHeadlineToOutput = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function enableAddHeadlineToOutput()
    {
        $this->addHeadlineToOutput = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function disableHasHeadline()
    {
        $this->resetHeadline();
        $this->rewind();

        return $this;
    }

    /**
     * @return $this
     */
    public function enableHasHeadline()
    {
        $this->updateHeadline();
        $this->rewind();

        return $this;
    }

    private function updateHeadline()
    {
        $this->initialLineNumber    = 0;
        $wasEnabled                 = $this->addHeadlineToOutput;

        if ($wasEnabled) {
            $this->disableAddHeadlineToOutput();
        }
        $this->setHeadline($this->readOne(0));
        if ($wasEnabled) {
            $this->enableAddHeadlineToOutput();
        }
    }

    /**
     * @return false|array
     */
    public function readHeadline()
    {
        return $this->getHeadline();
    }
    //end of headlines

    //begin of general
    /**
     * @param Combine $combine
     * @return $this
     */
    public function setCombine(Combine $combine)
    {
        $this->combine = $combine;

        return $this;
    }

    /**
     * @param null|int $lineNumber - if "null", current line number is used
     * @return array|bool|string
     */
    public function readOne($lineNumber = null)
    {
        $file           = $this->getFileHandler();
        $headline       = $this->getHeadline();
        $hasHeadline    = $this->hasHeadline();
        $this->seekFileToCurrentLineNumberIfNeeded($file, $lineNumber);

        $addHeadline    = ($hasHeadline && $this->addHeadlineToOutput && ($this->current() !== false));
        $content        = ($addHeadline)
            ? $this->combine->combine($headline, $this->current())
            : $this->current();
        $this->next();

        return $content;
    }

    /**
     * @param int $length
     * @param null|int $lineNumberToStartWith - if "null", current line number is used
     * @return array
     */
    public function readMany($length, $lineNumberToStartWith = null)
    {
        $this->rewind();
        $lastLine       = $lineNumberToStartWith + $length;
        $lines          = [];
        $currentLine    = $lineNumberToStartWith;

        //foreach not usable here since it is calling rewind before iterating
        while ($currentLine < $lastLine) {
            $line   = $this->readOne($currentLine);
            $lines  = $this->addToLinesIfLineIsValid($lines, $line);
            if (!$this->valid()) {
                $currentLine = $lastLine;
            }
            ++$currentLine;
        }

        return $lines;
    }

    /**
     * @return array
     */
    public function readAll()
    {
        $this->rewind();
        $lines = [];

        while ($line = $this()) {
            $lines = $this->addToLinesIfLineIsValid($lines, $line);
        }

        return $lines;
    }
    //end of general

    /**
     * @return string
     */
    protected function getFileHandlerOpenMode()
    {
        return 'r';
    }

    /**
     * @param array $lines
     * @param mixed $line
     * @return array
     */
    private function addToLinesIfLineIsValid(array &$lines, $line)
    {
        if (!is_null($line)) {
            $lines[] = $line;
        }

        return $lines;
    }

    /**
     * @param SplFileObject $file
     * @param null|int $newLineNumber
     * @return SplFileObject
     */
    private function seekFileToCurrentLineNumberIfNeeded(SplFileObject $file, $newLineNumber = null)
    {
        $seekIsNeeded = ((!is_null($newLineNumber))
            && ($newLineNumber >= $this->initialLineNumber)
            && ($newLineNumber !== $this->key()));

        if ($seekIsNeeded) {
            $file->seek($newLineNumber);
        }

        return $file;
    }
}
