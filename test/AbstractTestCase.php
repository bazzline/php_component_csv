<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-04-24 
 */

namespace Test\Net\Bazzline\Component\Csv;

use Mockery;
use Net\Bazzline\Component\Csv\Reader\FilteredReader;
use Net\Bazzline\Component\Csv\Reader\FilteredReaderFactory;
use Net\Bazzline\Component\Csv\Reader\Reader;
use Net\Bazzline\Component\Csv\Reader\ReaderFactory;
use Net\Bazzline\Component\Csv\Reader\ReaderInterface;
use Net\Bazzline\Component\Csv\Writer\FilteredWriter;
use Net\Bazzline\Component\Csv\Writer\FilteredWriterFactory;
use Net\Bazzline\Component\Csv\Writer\Writer;
use Net\Bazzline\Component\Csv\Writer\WriterFactory;
use Net\Bazzline\Component\Csv\Writer\WriterInterface;
use Net\Bazzline\Component\GenericAgreement\Data\FilterableInterface;
use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{
    /** @var FilteredReaderFactory */
    private $filteredReaderFactory;

    /** @var FilteredWriterFactory */
    private $filteredWriterFactory;

    /** @var string */
    private $path;

    /** @var array */
    private $pathOfFiles;

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

        $this->filteredReaderFactory    = new FilteredReaderFactory();
        $this->filteredWriterFactory    = new FilteredWriterFactory();
        $this->path                     = __DIR__ . DIRECTORY_SEPARATOR . 'data';
        $this->pathOfFiles              = array();
        $this->readerFactory            = new ReaderFactory();
        $this->writerFactory            = new WriterFactory();
    }

    public function __destruct()
    {
        foreach ($this->pathOfFiles as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
        Mockery::close();
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
     * @param string $name
     * @return string
     */
    protected function createRealFilePath($name)
    {
        $path                   = $this->path . DIRECTORY_SEPARATOR . $name;
        $this->pathOfFiles[]    = $path;

        return $path;
    }

    /**
     * @return FilteredReader
     */
    protected function createFilteredReader()
    {
        return $this->filteredReaderFactory->create();
    }

    /**
     * @return ReaderInterface
     */
    protected function createReader()
    {
        return $this->readerFactory->create();
    }



    /**
     * @return \Mockery\MockInterface|FilterableInterface
     */
    protected function createFilter()
    {
        return Mockery::mock('Net\Bazzline\Component\GenericAgreement\Data\FilterableInterface');
    }

    /**
     * @return FilteredWriter
     */
    protected function createFilteredWriter()
    {
        return $this->filteredWriterFactory->create();
    }

    /**
     * @return Writer|WriterInterface
     */
    protected function createWriter()
    {
        return $this->writerFactory->create();
    }

    /**
     * @return boolean
     */
    protected function phpVersionLessThen5Dot4()
    {
        return (version_compare(phpversion(), '5.4', '<'));
    }
}