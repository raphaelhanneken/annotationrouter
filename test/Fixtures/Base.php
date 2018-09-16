<?php


namespace Tests\AnnotationRoute\Fixtures;


use BadMethodCallException;

class Base
{
    /**
     * GET /
     */
    public function index()
    {
        throw new BadMethodCallException();
    }
}
