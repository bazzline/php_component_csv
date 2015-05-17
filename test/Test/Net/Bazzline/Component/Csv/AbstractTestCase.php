<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-04-24 
 */

namespace Test\Net\Bazzline\Component\Csv;

use Net\Bazzline\Component\Csv\Reader\Reader;
use Net\Bazzline\Component\Csv\Reader\ReaderFactory;
use Net\Bazzline\Component\Csv\Writer\Writer;
use Net\Bazzline\Component\Csv\Writer\WriterFactory;
use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /** @var ReaderFactory */
    private $readerFactory;

    /** @var WriterFactory */
    private $writerFactory;

    /**
     * Constructs a test case with the given name.
     *
     * @param string $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->readerFactory = new ReaderFactory();
        $this->writerFactory = new WriterFactory();
    }

    /**
     * @param int $permissions
     * @param string $path
     * @return \org\bovigo\vfs\vfsStreamDirectory
     */
    protected function createFilesystem($permissions = 0700, $path = 'root')
    {
        return vfsStream::setup($path, $permissions);
    }

    /**
     * @param string $name
     * @param int $permissions
     * @return \org\bovigo\vfs\vfsStreamFile
     */
    protected function createFile($name = 'test.csv', $permissions = 0700)
    {
        return vfsStream::newFile($name, $permissions);
    }

    /**
     * @return Reader
     */
    protected function createReader()
    {
        return $this->readerFactory->create();
    }

    /**
     * @return Writer
     */
    protected function createWriter()
    {
        return $this->writerFactory->create();
    }
}