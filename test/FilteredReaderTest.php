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
        $filter->shouldReceive('filter')
            ->andReturn(null);

        $reader->setFilter($filter);
        $reader->setPath($file->url());

        $this->assertFalse($reader->readOne());
        $this->assertFalse($reader());
        $this->assertEquals([], $reader->readAll());
    }

    public function testReadAllPassingSecondRowAsValidFilter()
    {
        $lineNumberOfContent    = 1;
        $content                = $this->contentAsArray;
        $expectedContent        = [
            $content[
                $lineNumberOfContent
            ]
        ];
        $file                   = $this->createFile();
        $filesystem             = $this->createFilesystem();
        $filter                 = $this->createFilter();
        $reader                 = $this->createFilteredReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $filter->shouldReceive('filter')
            ->andReturn(null, $expectedContent[0], null, null);

        $reader->setFilter($filter);
        $reader->setPath($file->url());

        $this->assertEquals($expectedContent, $reader->readAll());
    }

    public function testReadManyPassingSecondRowAsValidFilter()
    {
        $content                = $this->contentAsArray;
        $expectedContent        = [];
        $length                 = 2;
        $file                   = $this->createFile();
        $filesystem             = $this->createFilesystem();
        $filter                 = $this->createFilter();
        $reader                 = $this->createFilteredReader();
        $start                  = 2;

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);

        //generating expected content
        $end        = $start + $length;
        $counter    = ($start + 1);    //+1 because of the first false from the filter

        while ($counter < $end) {
            $expectedContent[] = $content[$counter];
            ++$counter;
        }

        $filter->shouldReceive('filter')
            ->andReturn(null, $expectedContent[0]);

        $reader->setFilter($filter);
        $reader->setPath($file->url());

        $this->assertEquals($expectedContent, $reader->readMany($length, $start));
    }

    public function testReadOnePassingSecondRowAsValidFilter()
    {
        $lineNumberOfContent    = 1;
        $content                = $this->contentAsArray;
        $expectedContent        = $content[$lineNumberOfContent];
        $file                   = $this->createFile();
        $filesystem             = $this->createFilesystem();
        $filter                 = $this->createFilter();
        $reader                 = $this->createFilteredReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $filter->shouldReceive('filter')
            ->andReturn(null, $expectedContent);

        $reader->setFilter($filter);
        $reader->setPath($file->url());

        $this->assertEquals($expectedContent, $reader());
    }
}
