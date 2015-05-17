<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-17 
 */

namespace Test\Net\Bazzline\Component\Csv;

use Net\Bazzline\Component\Csv\Reader\EasyCsvReaderAdapter;

/**
 * Class EasyCsvReaderAdapterTest
 * @package Test\Net\Bazzline\Component\Csv
 * @see https://github.com/jwage/easy-csv/blob/0.0.1/tests/EasyCSV/Tests/ReaderTest.php
 */
class EasyCsvReaderAdapterTest extends AbstractTestCase
{
    /**
     * @dataProvider getReaders
     * @param EasyCsvReaderAdapter $reader
     */
    public function testOneAtAtime(EasyCsvReaderAdapter $reader)
    {
        while ($row = $reader->getRow()) {
            $this->assertTrue(is_array($row));
            $this->assertEquals(3, count($row));
        }
    }

    /**
     * @dataProvider getReaders
     * @param EasyCsvReaderAdapter $reader
     */
    public function testGetAll(EasyCsvReaderAdapter $reader)
    {
        $this->assertEquals(5, count($reader->getAll()));
    }

    /**
     * @dataProvider getReaders
     * @param EasyCsvReaderAdapter $reader
     */
    public function testGetHeaders(EasyCsvReaderAdapter $reader)
    {
        $this->assertEquals(array("column1", "column2", "column3"), $reader->getHeaders());
    }

    /**
     * @return array
     */
    public function getReaders()
    {
        $file                           = $this->createFile('read.csv');
        $fileWithSemicolonAsDelimiter   = $this->createFile('read_sc.csv');
        $filesystem                     = $this->createFilesystem();

        $file->setContent(
            '"column1", "column2", "column3"' . PHP_EOL .
            '"1column2value", "1column3value", "1column4value"' . PHP_EOL .
            '"2column2value", "2column3value", "2column4value"' . PHP_EOL .
            '"3column2value", "3column3value", "3column4value"' . PHP_EOL .
            '"4column2value", "4column3value", "4column4value"' . PHP_EOL .
            '"5column2value", "5column3value", "5column4value"'
        );
        $fileWithSemicolonAsDelimiter->setContent(
            '"column1"; "column2"; "column3"' . PHP_EOL .
            '"1column2value"; "1column3value"; "1column4value"' . PHP_EOL .
            '"2column2value"; "2column3value"; "2column4value"' . PHP_EOL .
            '"3column2value"; "3column3value"; "3column4value"' . PHP_EOL .
            '"4column2value"; "4column3value"; "4column4value"' . PHP_EOL .
            '5column2value"; "5column3value"; "5column4value"'
        );

        $filesystem->addChild($file);
        $filesystem->addChild($fileWithSemicolonAsDelimiter);

        $reader                         = new EasyCsvReaderAdapter($file->url());
        $readerWithSemicolonAsDelimiter = new EasyCsvReaderAdapter($fileWithSemicolonAsDelimiter->url());

        $readerWithSemicolonAsDelimiter->setDelimiter(';');

        return array(
            array($reader),
            array($readerWithSemicolonAsDelimiter)
        );
    }


    public function testReadWrittenFile()
    {
        $content    = 'column1,column2,column3' . PHP_EOL .
            '1test1,"1test2ing this out",1test3' . PHP_EOL .
            '2test1,"2test2 ing this out ok",2test3' . PHP_EOL;
        $file       = $this->createFile('write.csv');
        $file->setContent($content);
        $filesystem = $this->createFilesystem();
        $filesystem->addChild($file);

        $reader     = new EasyCsvReaderAdapter($file->url());

        $results    = $reader->getAll();
        $expected   = array(
            array(
                'column1' => '1test1',
                'column2' => '1test2ing this out',
                'column3' => '1test3'
            ),
            array(
                'column1' => '2test1',
                'column2' => '2test2 ing this out ok',
                'column3' => '2test3'
            )
        );

        $this->assertEquals($expected, $results);
    }
}