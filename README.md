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

* works with PHP 5.3 and above
* \_\_invoke() implemented to use it as function
* unified reader and writer
* adapter to easy up migration from [EasyCsv - 0.0.1](https://github.com/jwage/easy-csv/tree/0.0.1/lib/EasyCSV) to this component
    * [writer](https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Writer.php)
    * [reader](https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Reader.php)
* reader
    * implemented iterator
    * readOne();
    * readMany();
    * readAll();
* writer
    * truncate();
    * delete();
    * copy();
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

## Reader

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

## Write

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

# API

[API](http://www.bazzline.net/55371e9f93dbdec83dc82730a5a73db5fc36272e/index.html) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * extend unit tests
        * implement \_\_clone();
        * write documentation
        * write adapter to easy up migration from [EasyCsv - 0.0.2](https://github.com/jwage/easy-csv/tree/0.0.2/lib/EasyCSV) to this component
    * added link to api
    * added minimum php version requirement
    * removed "TODO"
* [1.0.0](https://github.com/bazzline/php_component_csv/tree/1.0.0) - released at 07.06.2015
    * initial release 

# Other great component

* [goodby/csv](https://github.com/goodby/csv)
* [thephpleague/csv](https://github.com/thephpleague/csv)
* [keboola/php-csv](https://github.com/keboola/php-csv)
* [ajgarlag/AiglCsv](https://github.com/ajgarlag/AjglCsv)
* [jwage/easy-csv](https://github.com/jwage/easy-csv)
* [swt83/php-csv](https://github.com/swt83/php-csv)
