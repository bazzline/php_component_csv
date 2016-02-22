<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-09
 */
namespace Net\Bazzline\Component\Csv\Reader;

use Iterator;
use Net\Bazzline\Component\Csv\BaseInterface;
use Net\Bazzline\Component\Toolbox\HashMap\Combine;

/**
 * Interface ReaderInterface
 * @package Net\Bazzline\Component\Csv\Reader
 */
interface ReaderInterface extends BaseInterface, Iterator
{
    /**
     * @return $this
     */
    public function disableAddHeadlineToOutput();

    /**
     * @return $this
     */
    public function enableAddHeadlineToOutput();

    /**
     * @return $this
     */
    public function disableHasHeadline();

    /**
     * @return $this
     */
    public function enableHasHeadline();

    /**
     * @return false|array
     */
    public function readHeadline();

    /**
     * @param Combine $combine
     * @return $this
     */
    public function setCombine(Combine $combine);

    /**
     * @param null|int $lineNumber - if "null", current line number is used
     * @return array|bool|string
     */
    public function readOne($lineNumber = null);

    /**
     * @param int $length
     * @param null|int $lineNumberToStartWith - if "null", current line number is used
     * @return array
     */
    public function readMany($length, $lineNumberToStartWith = null);

    /**
     * @return array
     */
    public function readAll();
}