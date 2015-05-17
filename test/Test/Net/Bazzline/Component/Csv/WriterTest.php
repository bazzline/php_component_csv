<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-03
 */

namespace Test\Net\Bazzline\Component\Csv;

//@todo implement call of this tests with different delimiters etc. (after the
//setters are developed
//@todo implement writeOne(!array)
class WriterTest extends AbstractTestCase
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

    private $enclosures = array(
        's',
        '"',
        '|'
    );

    private $delimiters = array(
        's',
        'l',
        '-',
        ',',
        ';'
    );

    public function testWriteContentLinePerLineUsingWriteOne()
    {
        $delimiters = $this->delimiters;

        foreach ($delimiters as $delimiter) {
            $collection         = $this->contentAsArray;
            $expectedContent    = $this->convertArrayToStrings($collection, $delimiter);
            $file               = $this->createFile();
            $filesystem         = $this->createFilesystem();
            $writer             = $this->createWriter();

            $filesystem->addChild($file);
            $writer->setDelimiter($delimiter);
            $writer->setPath($file->url());

            foreach ($collection as $content) {
                $this->assertNotFalse($writer->writeOne($content));
            }

            $this->assertEquals($expectedContent, $file->getContent());
        }
    }

    public function testWriteContentLinePerLineUsingWriterAsAFunction()
    {
        $delimiters = $this->delimiters;

        foreach ($delimiters as $delimiter) {
            $collection         = $this->contentAsArray;
            $expectedContent    = $this->convertArrayToStrings($collection, $delimiter);
            $file               = $this->createFile();
            $filesystem         = $this->createFilesystem();
            $writer             = $this->createWriter();

            $filesystem->addChild($file);
            $writer->setDelimiter($delimiter);
            $writer->setPath($file->url());

            foreach ($collection as $content) {
                $this->assertNotFalse($writer($content));
            }

            $this->assertEquals($expectedContent, $file->getContent());
        }
    }

    public function testWriteAllContentAtOnce()
    {
        $delimiters = $this->delimiters;

        foreach ($delimiters as $delimiter) {
            $collection         = $this->contentAsArray;
            $expectedContent    = $this->convertArrayToStrings($collection, $delimiter);
            $file               = $this->createFile();
            $filesystem         = $this->createFilesystem();
            $writer             = $this->createWriter();

            $filesystem->addChild($file);
            $writer->setDelimiter($delimiter);
            $writer->setPath($file->url());

            //simple write the content two times
            $this->assertNotFalse($writer->writeMany($collection));
            $this->assertNotFalse($writer->writeAll($collection));

            $this->assertEquals($expectedContent, $file->getContent());
        }
    }

    public function testWriteManyContentAtOnce()
    {
        $delimiters = $this->delimiters;

        foreach ($delimiters as $delimiter) {
            $collection         = $this->contentAsArray;
            $expectedContent    = $this->convertArrayToStrings($collection, $delimiter);
            $file               = $this->createFile();
            $filesystem         = $this->createFilesystem();
            $writer             = $this->createWriter();

            $filesystem->addChild($file);
            $writer->setDelimiter($delimiter);
            $writer->setPath($file->url());

            $this->assertNotFalse($writer->writeMany($collection));

            $this->assertEquals($expectedContent, $file->getContent());
        }
    }

    public function testTruncate()
    {
        $delimiters = $this->delimiters;

        foreach ($delimiters as $delimiter) {
            $collection         = $this->contentAsArray;
            $content            = $this->convertArrayToStrings($collection, $delimiter);
            $file               = $this->createFile();
            $filesystem         = $this->createFilesystem();
            $writer             = $this->createWriter();

            $file->setContent($content);
            $filesystem->addChild($file);
            $writer->setDelimiter($delimiter);
            $writer->setPath($file->url());

            $writer->truncate();

            $this->assertEquals('', $file->getContent());
        }
    }

    public function testDelete()
    {
        $delimiters = $this->delimiters;

        foreach ($delimiters as $delimiter) {
            $collection         = $this->contentAsArray;
            $content            = $this->convertArrayToStrings($collection, $delimiter);
            $file               = $this->createFile();
            $filesystem         = $this->createFilesystem();
            $writer             = $this->createWriter();

            $file->setContent($content);
            $filesystem->addChild($file);
            $writer->setDelimiter($delimiter);
            $writer->setPath($file->url());

            $this->assertTrue(file_exists($file->url()));
            $writer->delete();
            $this->assertFalse(file_exists($file->url()));
        }
    }

    public function testCopy()
    {
        $delimiters = $this->delimiters;

        foreach ($delimiters as $delimiter) {
            $collection         = $this->contentAsArray;
            $content            = $this->convertArrayToStrings($collection, $delimiter);
            $file               = $this->createFile();
            $filesystem         = $this->createFilesystem();
            $writer             = $this->createWriter();

            $file->setContent($content);
            $filesystem->addChild($file);

            $sourceFilePath         = $file->url();
            $destinationFilePath    = str_replace('test.csv', 'foobar.csv', $file->url());

            $writer->setDelimiter($delimiter);
            $writer->setPath($sourceFilePath);

            $this->assertFalse(file_exists($destinationFilePath));
            $writer->copy($destinationFilePath);
            $this->assertTrue(file_exists($destinationFilePath));
        }
    }

    public function testCopyWithSettingNewPathAsCurrentPath()
    {
        $delimiters = $this->delimiters;

        foreach ($delimiters as $delimiter) {
            $collection         = $this->contentAsArray;
            $content            = $this->convertArrayToStrings($collection, $delimiter);
            $file               = $this->createFile();
            $filesystem         = $this->createFilesystem();
            $writer             = $this->createWriter();

            $file->setContent($content);
            $filesystem->addChild($file);

            $sourceFilePath         = $file->url();
            $destinationFilePath    = str_replace('test.csv', 'foobar.csv', $file->url());

            $writer->setDelimiter($delimiter);
            $writer->setPath($sourceFilePath);

            $this->assertFalse(file_exists($destinationFilePath));
            $writer->copy($destinationFilePath, true);
            $this->assertTrue(file_exists($destinationFilePath));
        }
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
            foreach ($contents as &$part) {
                $contains = $this->stringContains(' ');
                if ($contains->evaluate($part, '', true)) {
                    $part = '"' . $part . '"';
                }
            }
            $string .= implode($delimiter, $contents) . PHP_EOL;
        }

        return $string;
    }
}
