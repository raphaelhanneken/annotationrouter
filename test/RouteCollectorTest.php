<?php

namespace Tests\AnnotationRoute;

use AnnotationRoute\RouteCollector;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteParser\Std;
use PHPUnit\Framework\TestCase;
use Tests\AnnotationRoute\Fixtures\HomeController;
use Tests\AnnotationRoute\Fixtures\UsersController;

/**
 * Class RouteCollectorTest
 *
 * @package Tests\AnnotationRoute
 * @covers \AnnotationRoute\RouteCollector
 */
class RouteCollectorTest extends TestCase
{
    /** @var RouteCollector */
    private $routeCollector;

    public function setUp()
    {
        $this->routeCollector = new RouteCollector(new Std(), new GroupCountBased());
    }

    /**
     * @throws \ReflectionException
     */
    public function testAddRoutesInPathWithNamespace()
    {
        chdir(dirname(__DIR__));
        $this->routeCollector->addRoutesInPathWithNamespace('test/Fixtures', 'Tests\\AnnotationRoute\\Fixtures');

        $this->assertEquals(require __DIR__ . '/data/path_results.php', $this->routeCollector->getData());
    }

    /**
     * @throws \ReflectionException
     */
    public function testAddRoutesForClass()
    {
        $this->routeCollector->addRoutesForClass(UsersController::class);
        $this->routeCollector->addRoutesForClass(HomeController::class);

        $this->assertEquals(require __DIR__ . '/data/class_results.php', $this->routeCollector->getData());
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @throws \ReflectionException
     */
    public function testThrowsExceptionOnIvalidPath()
    {
        $this->routeCollector->addRoutesInPathWithNamespace('/non/existent/path', 'false/namespace');
    }

    /**
     * @throws \ReflectionException
     */
    public function testCatchesExceptionForInvalidClassName()
    {
        $this->routeCollector->addRoutesForClass('An\\Invalid\\Class');
        $this->assertTrue(true);
    }

    public function testAddRoute()
    {
        $this->routeCollector->addRoute(['GET'], '/users/{id}', 'UsersController:show');
        $this->assertEquals(require __DIR__ . '/data/single_route_results.php', $this->routeCollector->getData());
    }
}
