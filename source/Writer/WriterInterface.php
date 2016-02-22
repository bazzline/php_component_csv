<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-09-09
 */
namespace Net\Bazzline\Component\Csv\Writer;

use Net\Bazzline\Component\Csv\BaseInterface;

/**
 * Interface WriterInterface
 * @package Net\Bazzline\Component\Csv\Writer
 */
interface WriterInterface extends BaseInterface
{
    /**
     * @param mixed|array $data
     * @return false|int
     */
    public function __invoke($data);


    /**
     * @param string $path
     * @param bool $setPathAsCurrentPath
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function copy($path, $setPathAsCurrentPath = false);

    /**
     * @param string $path
     * @return bool
     */
    public function move($path);

    /**
     * @return bool
     */
    public function delete();

    public function truncate();

    /**
     * truncates file and writes content
     *
     * @param array $collection
     * @return false|int
     */
    public function writeAll(array $collection);

    /**
     * @param array $headlines
     * @return false|int
     */
    public function writeHeadlines(array $headlines);

    /**
     * @param array $collection
     * @return false|int
     */
    public function writeMany(array $collection);

    /**
     * @param string|array $data
     * @return false|int
     */
    public function writeOne($data);
}