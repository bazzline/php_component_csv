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
    public function testReadWholeContentLinePerLineAndAlwaysInvalidFilter()
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

        while ($line = $reader->readOne()) {
            $this->assertNull($line);
        }
    }
}
