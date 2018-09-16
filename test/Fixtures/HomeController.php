<?php


namespace Tests\AnnotationRoute\Fixtures;


use BadMethodCallException;

class HomeController extends Base
{
    /**
     * GET /about_us
     */
    public function index()
    {
        throw new BadMethodCallException();
    }
}
