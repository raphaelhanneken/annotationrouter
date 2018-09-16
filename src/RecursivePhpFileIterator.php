<?php


namespace AnnotationRoute;


use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class RecursivePhpFileIterator extends RegexIterator
{
    /**
     * Recursively iterate over php files within a given directory. Optionally filter files
     * by a given postfix, e.g. only iterate over files that end with ...Controller.php.
     *
     * @param string $path
     * @param string $filePostfix
     */
    public function __construct(string $path, $filePostfix = '')
    {
        parent::__construct(
            new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)),
            '/.+' . $filePostfix . '\.php/'
        );
    }
}
