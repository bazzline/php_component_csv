# CSV Handling Component for PHP

This project aims to deliver an easy to use and free as in freedom php compontent for dealing with csv files (read and write).


This component is heavily influenced by [jwage/easy-csv](https://github.com/jwage/easy-csv).
It was mainly created created because of missing compatibility with php 5.3 and no official packagist support from [jwage/easy-csv](https://github.com/jwage/easy-csv).

####
The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/php_component_csv.png?branch=master)](http://travis-ci.org/bazzline/php_component_csv)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_csv.svg)](https://packagist.org/packages/net_bazzline/php_component_csv)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_csv/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_csv/) | [![build status](https://scrutinizer-ci.com/g/bazzline/php_component_csv/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_csv/)

The versioneye status is:
[![Dependency Status](https://www.versioneye.com/user/projects/557492b1316137000d0000d0/badge.svg?style=flat)](https://www.versioneye.com/user/projects/557492b1316137000d0000d0)

Take a look on [openhub.net](https://www.openhub.net/p/php_component_csv).

# Benefits

* low and stable memory usage (give it a try by using [benchmarkReader](https://github.com/bazzline/php_component_csv/blob/master/example/benchmarkReader) and [benchmarkWriter](https://github.com/bazzline/php_component_csv/blob/master/example/benchmarkWriter))
* works with PHP 5.3 and above
* \_\_invoke() implemented to use it as function
* unified reader and writer
* adapter to easy up migration from [EasyCsv - 0.0.1](https://github.com/jwage/easy-csv/tree/0.0.1/lib/EasyCSV) to this component
    * [writer](https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Writer.php)
    * [reader](https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Reader.php)
* usage of [validators](https://github.com/bazzline/php_component_csv/blob/master/source/Net/Bazzline/Component/Csv/Validator/ValidatorInterface.php) - control what comes in and what comes out
* reader
    * implemented iterator
    * readOne();
    * readMany();
    * readAll();
* writer
    * copy();
    * delete();
    * move();
    * truncate();
    * writeOne();
    * writeMany();
    * writeAll();   //truncates file and writes content

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_csv
cd vendor/net_bazzline/php_component_csv
git clone https://github.com/bazzline/php_component_csv .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_csv)

```
    composer require net_bazzline/php_component_csv:dev-master
```

# Usage

## [Reader](http://www.bazzline.net/55371e9f93dbdec83dc82730a5a73db5fc36272e/class-Net.Bazzline.Component.Csv.Reader.Reader.html)

### Read Content

```php
$reader = new Reader('my/file.csv');

//read one line
echo $reader->readOne() . PHP_EOL;

//read 10 lines
foreach ($reader->readMany(10) as $line) {
    echo $line . PHP_EOL;
}

//read all lines
foreach ($reader->readAll() as $line) {
    echo $line . PHP_EOL;
}
```

#### By Iteration

```php
$reader = new Reader('my/file.csv');

if ($reader->hasHeadline()) {
    echo 'headlines: ' . $reader->readHeadline();
}

foreach ($reader as $line) {
    echo $line . PHP_EOL;
}
```

#### By Using As A Function

```php
$reader = new Reader('my/file.csv');

while ($line = $reader()) {
    echo $line . PHP_EOL;
}
```

## [Writer](http://www.bazzline.net/55371e9f93dbdec83dc82730a5a73db5fc36272e/class-Net.Bazzline.Component.Csv.Writer.Writer.html)

### Write Content

#### By Iteration

```php
//$headlines contains a php array
//$lines contains a php array of arrays
$writer = new Writer('my/file.csv');

$writer->writeHeadline($headlines);

foreach ($lines as $line) {
    $writer->writeOne($line);
}
```

#### At Once

```php
//$headlines contains a php array
//$lines contains a php array of arrays
$writer = new Writer('my/file.csv');

$writer->writeHeadline($headlines);
$writer->writeMany($lines);
```

#### By Using As A Function

```php
//$line contains a php array
//$lines contains a php array of arrays
$writer = new Writer('my/file.csv');

$writer($line);

foreach ($lines as $line) {
    $writer($lines);
}
```

### Truncate

```php
$writer = new Writer('my/file.csv');

$writer->truncate();
```

### Copy

```php
$writer = new Writer('my/file.csv');

$writer->copy('my/my_first_copy.csv');    //writer will still write into "my_first_copy.csv"

$writer->copy('my/my_second_copy.csv', true);    //writer will write in "my_second_copy.csv"
```

### Move

```php
$writer = new Writer('my/file.csv');

$writer->move('my/new_name.csv');   //writer will write in "new_name.csv"
```

# API

[API](http://www.bazzline.net/55371e9f93dbdec83dc82730a5a73db5fc36272e/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * add example for filter usage
        * add documentation for filter usage
        * extend unit tests
        * implement \_\_clone();
        * implement usage of filter in writer::copy
        * write documentation
        * write adapter to easy up migration from [EasyCsv - 0.0.2](https://github.com/jwage/easy-csv/tree/0.0.2/lib/EasyCSV) to this component
* [1.5.0](https://github.com/bazzline/php_component_csv/tree/1.5.0) - released at xx.07.2015
    * added dependency to [generic agreement](https://github.com/bazzline/php_component_generic_agreement)
        * replace [Filter](https://github.com/bazzline/php_component_csv/blob/1.4.0/source/Net/Bazzline/Component/Csv/Filter/FilterInterface.php) with [Validator](https://github.com/bazzline/php_component_csv/blob/1.4.0/source/Net/Bazzline/Component/Csv/Validator/ValidatorInterface.php)
* [1.4.0](https://github.com/bazzline/php_component_csv/tree/1.4.0) - released at 02.07.2015
    * started [cli](https://github.com/bazzline/php_component_csv/blob/master/example/cli] example to easy up usage
    * added "rewind" call when using reader::readAll() and reader::readMany()
* [1.3.0](https://github.com/bazzline/php_component_csv/tree/1.3.0) - released at 26.06.2015
    * added headline output support as keys for Reader::readMany()
    * added headline output support as keys for Reader::readOne()
        * can be disabled by Reader::disableAddHeadlineToOutput()
        * can be enabled by Reader::enableAddHeadlineToOutput()
        * is enabled by default
    * fixed broken unit test for php 5.3
    * moved complex array combine into [own project](https://github.com/bazzline/php_component_toolbox/blob/master/source/Net/Bazzline/Component/Toolbox/HashMap/Combine.php)
    * removed duplicated code in Reader
* [1.2.0](https://github.com/bazzline/php_component_csv/tree/1.2.0) - released at 25.06.2015
    * added examples ([benchmarkReader](https://github.com/bazzline/php_component_csv/blob/master/example/benchmarkReader), [benchmarkWriter](https://github.com/bazzline/php_component_csv/blob/master/example/benchmarkWriter), [reader](https://github.com/bazzline/php_component_csv/blob/master/example/reader) and [writer](https://github.com/bazzline/php_component_csv/blob/master/example/writer))
    * implemented filter for reader and writer by creating the [FilterInterface](https://github.com/bazzline/php_component_csv/blob/1.2.0/source/Net/Bazzline/Component/Csv/Filter/FilterInterface.php)
* [1.1.0](https://github.com/bazzline/php_component_csv/tree/1.1.0) - released at 10.06.2015
    * added link to api
    * added minimum php version requirement
    * implemented "move($path)" method into [Writer](https://github.com/bazzline/php_component_csv/blob/master/source/Net/Bazzline/Component/Csv/Writer/Writer.php)
    * removed "TODO"
    * updated dependencies
* [1.0.0](https://github.com/bazzline/php_component_csv/tree/1.0.0) - released at 07.06.2015
    * initial release 

# Other great component

* [goodby/csv](https://github.com/goodby/csv)
* [thephpleague/csv](https://github.com/thephpleague/csv)
* [keboola/php-csv](https://github.com/keboola/php-csv)
* [ajgarlag/AiglCsv](https://github.com/ajgarlag/AjglCsv)
* [jwage/easy-csv](https://github.com/jwage/easy-csv)
* [swt83/php-csv](https://github.com/swt83/php-csv)
