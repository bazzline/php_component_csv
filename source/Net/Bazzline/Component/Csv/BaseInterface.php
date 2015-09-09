<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-09
 */
namespace Net\Bazzline\Component\Csv;

/**
 * Interface BaseInterface
 * @package Net\Bazzline\Component\Csv
 */
interface BaseInterface
{
    /**
     * @return bool
     */
    public function hasHeadline();

    /**
     * @param string $delimiter
     * @throws InvalidArgumentException
     */
    public function setDelimiter($delimiter);

    /**
     * @param string $enclosure
     * @throws InvalidArgumentException
     */
    public function setEnclosure($enclosure);

    /**
     * @param string $escapeCharacter
     * @throws InvalidArgumentException
     */
    public function setEscapeCharacter($escapeCharacter);

    /**
     * @param string $path
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setPath($path);
}