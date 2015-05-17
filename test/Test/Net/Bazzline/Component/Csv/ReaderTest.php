<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-04-24 
 */

namespace Test\Net\Bazzline\Component\Csv;

//@todo implement call of this tests with different delimiters etc. (after the 
//setters are developed
class ReaderTest extends AbstractTestCase
{
    /**
     * @var array
     */
    private $contentAsArray = array(
        array(
            'headlines foo',
            'headlines bar'
        ),
        array(
            'foo',
            'bar'
        ),
        array(
            'foobar',
            'baz'
        ),
        array(
            'baz',
            'barfoo'
        )
    );

    public function testHasHeadline()
    {
        $content    = $this->contentAsArray;
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $expectedContent    = array_slice($content, 1);
        $expectedHeadline   = $content[0];
        $expectedContent    = $this->addHeadlineAsKeysToContent($expectedHeadline, $expectedContent);

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());
        $reader->enableHasHeadline();

        $this->assertTrue($reader->hasHeadline(), 'has headline');
        $this->assertEquals($expectedContent, $reader->readAll(), 'read all');
        $this->assertEquals($expectedHeadline, $reader->readHeadline(), 'read headline');
    }

    public function testReadWholeContentAtOnce()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $this->assertFalse($reader->hasHeadline());
        $this->assertEquals($this->contentAsArray, $reader->readAll());
    }

    public function testReadWholeContentByUsingTheIteratorInterface()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $index = 0;
        foreach ($reader as $line) {
            $this->assertEquals($this->contentAsArray[$index], $line);
            ++$index;
        }
    }

    public function testReadWholeContentByUsingReaderAsAFunction()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $index = 0;

        while ($line = $reader()) {
            $this->assertEquals($this->contentAsArray[$index], $line);
            ++$index;
        }
    }

    public function testReadWholeContentLinePerLine()
    {
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $index = 0;

        while ($line = $reader->readOne()) {
            $this->assertEquals($this->contentAsArray[$index], $line);
            ++$index;
        }
    }

    /**
     * @return array
     */
    public function readChunkOfTheContentDataProvider()
    {
        $content        = $this->contentAsArray;
        $indices        = array_keys($content);
        $length         = count($indices);

        return array(
            'read only the first line' => array(
                'content'   => $content,
                'end'       => $indices[1],
                'start'     => $indices[0]
            ),
            'read one line the middle' => array(
                'content'   => $content,
                'end'       => $indices[2],
                'start'     => $indices[1]
            ),
            'read whole content' => array(
                'content'   => $content,
                'end'       => $indices[($length - 1)],
                'start'     => $indices[0]
            )
        );
    }

    /**
     * @dataProvider readChunkOfTheContentDataProvider
     * @param string $content
     * @param int $end
     * @param int $start
     */
    public function testReadChunkOfTheContentByProvidingStartLineNumberAndAmountOfLines($content, $end, $start)
    {
        $file           = $this->createFile();
        $filesystem     = $this->createFilesystem();
        $length         = ($end - $start);
        $reader         = $this->createReader();

        $file->setContent($this->convertArrayToStrings($content));
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        $expectedContent = array();

        $counter = $start;

        while ($counter < $end) {
            $expectedContent[] = $content[$counter];
            ++$counter;
        }

        $this->assertEquals($expectedContent, $reader->readMany($length, $start));
    }

    public function testReadContentByProvidingTheCurrentLineNumber()
    {
        $data       = $this->contentAsArray;
        $file       = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader     = $this->createReader();

        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());

        foreach ($data as $lineNumber => $line) {
            $this->assertEquals($line, $reader->readOne($lineNumber));
        }
    }

    public function testReadContentByProvidingTheCurrentLineNumberByUsingReaderAsAFunction()
    {
        $data = $this->contentAsArray;
        $file = $this->createFile();
        $filesystem = $this->createFilesystem();
        $reader = $this->createReader();
        $file->setContent($this->getContentAsString());
        $filesystem->addChild($file);
        $reader->setPath($file->url());
        foreach($data as $lineNumber => $line) {
            $this->assertEquals($line, $reader($lineNumber));
        }
    }

    /**
     * @param array $headline
     * @param array $content
     * @return array
     */
    private function addHeadlineAsKeysToContent(array $headline, array $content)
    {
        $adaptedContent = array();

        foreach ($content as $key => $columns) {
            $adaptedContent[$key] = array();
            foreach ($columns as $columnKey => $columnContent) {
                $adaptedContent[$key][$headline[$columnKey]] = $columnContent;
            }
        }

        return $adaptedContent;
    }

    /**
     * @return string
     */
    private function getContentAsString()
    {
        return $this->convertArrayToStrings($this->contentAsArray);
    }

    /**
     * @param array $data
     * @param string $delimiter
     * @return string
     */
    private function convertArrayToStrings(array $data, $delimiter = ',')
    {
        $string = '';

        foreach ($data as $contents) {
            $string .= implode($delimiter, $contents) . PHP_EOL;
        }

        return $string;
    }
}
