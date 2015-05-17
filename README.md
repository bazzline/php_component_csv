# CSV Handling Component for PHP

* heavily influenced by [jwage/easy-csv](https://github.com/jwage/easy-csv)
* only created because of missing compatibility with php 5.3 and no official packagist support

# Installation @todo

# Usage

## Read

### Read Content

TODO: add other ways (readOne/readMany/readAll)

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

# Other great component

* https://github.com/goodby/csv
* https://github.com/thephpleague/csv
* https://github.com/keboola/php-csv
* https://github.com/ajgarlag/AjglCsv
* https://github.com/jwage/easy-csv
* https://github.com/swt83/php-csv

# Developer Logbook And Thoughts

* version 1 - done
    * writer
        * __invoke($data)   //write single line
        * ->writeOne($data);
        * ->writeMany(array $collection);
    * reader
        * __invoke()   //read single line
        * implements iterator
        * readOne();
        * readMany($limit);
        * readAll();
* version 2 - done
    * implement support in Reader|Writer for
        * setDelimiter
        * setEnclosure
    * factory
        * setDelimiter($this->getDelimiter()); //getters are protected to easy up extending
* version 3 - done
    * unify reader and writer
* version 4  - done
    * remove dependency to php 5.4 (https://php.net/manual/en/splfileobject.fputcsv.php)
    * setFilter(callable $filter);  //for readers and writers
    * writer
        * truncate();
        * delete();
        * copy($destination);
        * writeAll();   //truncates and writes content
* version 4
    * write adapter to easy up migration from [EasyCsv - 0.0.1](https://github.com/jwage/easy-csv/tree/0.0.1/lib/EasyCSV) to this component
    * [writer](https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Writer.php)
    * [reader](https://github.com/jwage/easy-csv/blob/master/lib/EasyCSV/Reader.php)
* future
    * extend unit tests
    * implement \__clone();
    * write documentation
    * write examples
    * write adapter to easy up migration from [EasyCsv - 0.0.2](https://github.com/jwage/easy-csv/tree/0.0.2/lib/EasyCSV) to this component

