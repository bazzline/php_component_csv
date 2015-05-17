<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-06 
 */

namespace Net\Bazzline\Component\Csv;

use SplFileObject;

abstract class AbstractBase
{
    /** @var string */
    private $delimiter = ',';

    /** @var string */
    private $enclosure = '"';

    /** @var string */
    private $escapeCharacter = '\\';

    /** @var false|array */
    private $headline = false;

    /** @var SplFileObject */
    private $handler;

    /** @var string */
    private $path;

    /**
     * @return bool
     */
    public function hasHeadline()
    {
        return ($this->headline !== false);
    }

    /**
     * @param string $delimiter
     * @throws InvalidArgumentException
     */
    public function setDelimiter($delimiter)
    {
        $this->assertIsASingleCharacterString($delimiter, 'delimiter');
        $this->delimiter = $delimiter;
        $this->updateCsvControl();
    }

    /**
     * @param string $enclosure
     * @throws InvalidArgumentException
     */
    public function setEnclosure($enclosure)
    {
        $this->assertIsASingleCharacterString($enclosure, 'enclosure');
        $this->enclosure = $enclosure;
        $this->updateCsvControl();
    }

    /**
     * @param string $escapeCharacter
     * @throws InvalidArgumentException
     */
    public function setEscapeCharacter($escapeCharacter)
    {
        $this->assertIsASingleCharacterString($escapeCharacter, 'escapeCharacter');
        $this->escapeCharacter = $escapeCharacter;
        $this->updateCsvControl();
    }

    /**
     * @param string $path
     * @return $this
     * @throws InvalidArgumentException
     * @todo implement validation
     */
    public function setPath($path)
    {
        $this->path     = $path;
        $this->handler  = $this->open($path);

        return $this;
    }

    /**
     * @return string
     */
    protected function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @return string
     */
    protected function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @return string
     */
    protected function getEscapeCharacter()
    {
        return $this->escapeCharacter;
    }

    /**
     * @return SplFileObject|resource
     */
    protected function getFileHandler()
    {
        return $this->handler;
    }

    /**
     * @return string
     */
    abstract protected function getFileHandlerOpenMode();

    /**
     * @return array|false
     */
    protected function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return $this->path;
    }

    /**
     * @return $this
     */
    protected function resetHeadline()
    {
        $this->headline = false;

        return $this;
    }

    /**
     * @param array $headline
     * @return $this
     */
    protected function setHeadline(array $headline)
    {
        $this->headline = $headline;

        return $this;
    }

    protected function close()
    {
        if (!is_null($this->handler)) {
            $this->headline = null;
        }
    }

    /**
     * @param string $path
     * @return SplFileObject
     * @todo inject or inject factory
     */
    protected function open($path)
    {
        $file = new SplFileObject($path, $this->getFileHandlerOpenMode());
        $file->setFlags(SplFileObject::READ_CSV);
        //@todo
        //$file->setFlags(SplFileObject::DROP_NEW_LINE);
        //$file->setFlags(SplFileObject::SKIP_EMPTY);

        return $file;
    }

    /**
     * @param string $variable
     * @param string $name
     * @throws InvalidArgumentException
     */
    private function assertIsASingleCharacterString($variable, $name)
    {
        if (!is_string($variable)) {
            $message = $name . ' must be of type "string"';

            throw new InvalidArgumentException($message);
        }
        if (strlen($variable) != 1) {
            $message = $name . ' must be a single character';

            throw new InvalidArgumentException($message);
        }
    }

    private function updateCsvControl()
    {
        $file = $this->getFileHandler();

        if ($file instanceof SplFileObject) {
            $file->setCsvControl(
                $this->getDelimiter(),
                $this->getEnclosure(),
                $this->getEscapeCharacter()
            );
        }
    }
}