# CSV Handling Component for PHP

This project aims to deliver an easy to use and free as in freedom php compontent for dealing with csv files (read and write).

This component is heavily influenced by [jwage/easy-csv](https://github.com/jwage/easy-csv).
It was mainly created because of missing compatibility with php 5.6 and no official packagist support from [jwage/easy-csv](https://github.com/jwage/easy-csv).

The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/php_component_csv.png?branch=master)](http://travis-ci.org/bazzline/php_component_csv)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_csv.svg)](https://packagist.org/packages/net_bazzline/php_component_csv)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_csv/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_csv/)

The versioneye status is:
[![Dependency Status](https://www.versioneye.com/user/projects/557492b1316137000d0000d0/badge.svg?style=flat)](https://www.versioneye.com/user/projects/557492b1316137000d0000d0)

Take a look on [openhub.net](https://www.openhub.net/p/php_component_csv).

The current change log can be found [here](https://github.com/bazzline/php_component_csv/blob/master/CHANGELOG.md).

# Benefits

* low and stable memory usage (give it a try by using [benchmarkReader](https://github.com/bazzline/php_component_csv/blob/master/example/benchmarkReader) and [benchmarkWriter](https://github.com/bazzline/php_component_csv/blob/master/example/benchmarkWriter))
* works with PHP 5.6 and above
* \_\_invoke() implemented to use it as function
* unified reader and writer
* adapter to easy up migration from [EasyCsv - 0.0.1](https://github.com/jwage/easy-csv/tree/0.0.1/lib/EasyCSV) to this component
    * [writer](https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Writer.php)
    * [reader](https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Reader.php)
* usage of [filters](https://github.com/bazzline/php_component_csv/blob/master/source/Net/Bazzline/Component/Csv/Filter) - control what comes in and what comes out
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
//I am using json_encode() since there is no official and best way how to
// output arrays on the command line.

//read one line
echo json_encode($reader->readOne()) . PHP_EOL;

//read 10 lines
foreach ($reader->readMany(10) as $line) {
    echo json_encode($line) . PHP_EOL;
}

//read all lines
foreach ($reader->readAll() as $line) {
    echo json_encode($line) . PHP_EOL;
}
```

#### By Iteration

```php
$reader = new Reader('my/file.csv');
//I am using json_encode() since there is no official and best way how to
// output arrays on the command line.

if ($reader->hasHeadline()) {
    echo 'headlines: ' . json_encode($reader->readHeadline());
}

foreach ($reader as $line) {
    echo json_encode($line) . PHP_EOL;
}
```

#### By Using As A Function

```php
$reader = new Reader('my/file.csv');
//I am using json_encode() since there is no official and best way how to
// output arrays on the command line.

while ($line = $reader()) {
    echo json_encode($line) . PHP_EOL;
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
    $writer($line);
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

$writer->copy('my/my_first_copy.csv');    //writer will still write into "file.csv"

$writer->copy('my/my_second_copy.csv', true);    //writer will write in "my_second_copy.csv"
```

### Move

```php
$writer = new Writer('my/file.csv');

$writer->move('my/new_name.csv');   //writer will write in "new_name.csv"
```

# API

[API](http://www.bazzline.net/55371e9f93dbdec83dc82730a5a73db5fc36272e/index.html) is available at [bazzline.net](http://www.bazzline.net).

# Other Great Components

* [goodby/csv](https://github.com/goodby/csv)
* [thephpleague/csv](https://github.com/thephpleague/csv)
* [keboola/php-csv](https://github.com/keboola/php-csv)
* [ajgarlag/AiglCsv](https://github.com/ajgarlag/AjglCsv)
* [jwage/easy-csv](https://github.com/jwage/easy-csv)
* [swt83/php-csv](https://github.com/swt83/php-csv)

# Hall of Fame - The list of contributors

* [peter279k](https://github.com/peter279k) - [homepage](https://peterli.website)
* [stevleibelt](https://github.com/stevleibelt) - [homepage](https://stev.leibelt.de)

# Contributing

Please see [CONTRIBUTING](https://github.com/bazzline/php_component_csv/blob/master/CONTRIBUTING.md) for details.

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if you use it. [Donate something](https://gratipay.com/~stevleibelt) if you love it :-].
