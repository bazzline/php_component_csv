<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-17 
 */

namespace Test\Net\Bazzline\Component\Csv;

use Net\Bazzline\Component\Csv\Writer\EasyCsvWriterAdapter;

/**
 * Class EasyCsvWriterAdapterTest
 * @package Test\Net\Bazzline\Component\Csv
 * @see https://github.com/jwage/easy-csv/blob/0.0.1/tests/EasyCSV/Tests/WriterTest.php
 */
class EasyCsvWriterAdapterTest extends AbstractTestCase
{
    public function testWriteRow()
    {
        $file       = $this->createFile('write.csv');
        $filesystem = $this->createFilesystem();
        $filesystem->addChild($file);
        $writer     = new EasyCsvWriterAdapter($file->url());

        $expectedContent    = 'test1,test2,test3' . PHP_EOL;
        $line               = 'test1, test2, test3';

        $writer->writeRow($line);

        $this->assertEquals($expectedContent, $file->getContent());
    }

    public function testWriteFromArray()
    {
        $file       = $this->createFile('write.csv');
        $filesystem = $this->createFilesystem();
        $filesystem->addChild($file);
        $writer     = new EasyCsvWriterAdapter($file->url());

        $array              = array(
            '1test1, 1test2ing this out, 1test3',
            array(
                '2test1', '2test2 ing this out ok', '2test3'
            )
        );
        $line               = 'column1, column2, column3';
        $expectedContent    = 'column1,column2,column3' . PHP_EOL .
            '1test1,"1test2ing this out",1test3' . PHP_EOL .
            '2test1,"2test2 ing this out ok",2test3' . PHP_EOL;

        $writer->writeRow($line);
        $writer->writeFromArray($array);

        $this->assertEquals($expectedContent, $file->getContent());
    }
}