<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-22
 */

namespace Test\Net\Bazzline\Component\Csv;

//@todo implement call of this tests with different delimiters etc. (after the
//setters are developed
//@todo implement writeOne(!array)
class FilteredReaderTest extends ReaderTest
{
    public function testReadContentWithAlwaysInvalidFilter()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $filter     = $this->createFilter();
        $reader     = $this->createFilteredReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $filter->shouldReceive('isValid')
            ->andReturn(false);

        $reader->setFilter($filter);
        $reader->setPath($file->url());

echo __METHOD__ . PHP_EOL;
        $this->assertNull($reader->readOne());
        $this->assertEquals(array(), $reader->readAll());
        $this->assertNull($reader());
    }

    public function testReadAllPassingSecondRowAsValidFilter()
    {
        $lineNumberOfContent    = 1;
        $collection             = $this->contentAsArray;
        $expectedContent        = array($collection[$lineNumberOfContent]);
        $file                   = $this->createFile();
        $filesystem             = $this->createFilesystem();
        $filter                 = $this->createFilter();
        $reader                 = $this->createFilteredReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $filter->shouldReceive('isValid')
            ->andReturn(false, true, false, false);

        $reader->setFilter($filter);
        $reader->setPath($file->url());

echo __METHOD__ . PHP_EOL;
echo 'expected: ' . var_export($expectedContent, true) . PHP_EOL;
echo 'actual: ' . var_export($reader->readAll(), true) . PHP_EOL;
        //$this->assertEquals($expectedContent, $reader->readAll());
    }

    public function testReadOnePassingSecondRowAsValidFilter()
    {
        $lineNumberOfContent    = 1;
        $collection             = $this->contentAsArray;
        $expectedContent        = $collection[$lineNumberOfContent];
        $file                   = $this->createFile();
        $filesystem             = $this->createFilesystem();
        $filter                 = $this->createFilter();
        $reader                 = $this->createFilteredReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $filter->shouldReceive('isValid')
            ->andReturn(false, true);

        $reader->setFilter($filter);
        $reader->setPath($file->url());

        $this->assertEquals($expectedContent, $reader());
    }
}
