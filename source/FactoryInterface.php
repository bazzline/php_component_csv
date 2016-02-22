<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-05-06 
 */

namespace Net\Bazzline\Component\Csv;

interface FactoryInterface
{
    /**
     * @return object
     */
    public function create();
}