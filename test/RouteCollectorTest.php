<?php

namespace Tests\AnnotationRoute;

use AnnotationRoute\Collector;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteParser\Std;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Tests\AnnotationRoute\Fixtures\HomeController;
use Tests\AnnotationRoute\Fixtures\UsersController;

/**
 * Class RouteCollectorTest
 *
 * @package Tests\AnnotationRoute
 * @covers \AnnotationRoute\Collector
 */
class RouteCollectorTest extends TestCase
{
    /** @var Collector */
    private $routeCollector;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->routeCollector = new Collector(new Std(), new GroupCountBased());
    }

    /**
     * @covers \AnnotationRoute\Collector::addRoutesInPathWithNamespace
     * @throws ReflectionException
     */
    public function testAddRoutesInPathWithNamespace(): void
    {
        $this->routeCollector->addRoutesInPathWithNamespace('test/Fixtures', 'Tests\\AnnotationRoute\\Fixtures');

        $this->assertEquals(require __DIR__ . '/data/path_results.php', $this->routeCollector->getData());
    }

    /**
     * @covers \AnnotationRoute\Collector::addRoutesForClass
     * @throws ReflectionException
     */
    public function testAddRoutesForClass(): void
    {
        $this->routeCollector->addRoutesForClass(UsersController::class);
        $this->routeCollector->addRoutesForClass(HomeController::class);

        $this->assertEquals(require __DIR__ . '/data/class_results.php', $this->routeCollector->getData());
    }

    /**
     * @covers \AnnotationRoute\Collector::addRoutesInPathWithNamespace
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function testThrowsExceptionOnIvalidPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->routeCollector->addRoutesInPathWithNamespace('/non/existent/path', 'false/namespace');
    }

    /**
     * @covers \AnnotationRoute\Collector::addRoutesForClass
     * @throws ReflectionException
     */
    public function testCatchesExceptionForInvalidClassName(): void
    {
        $this->expectException(ReflectionException::class);
        $this->routeCollector->addRoutesForClass('An\\Invalid\\Class');
    }

    /**
     * @covers \AnnotationRoute\Collector::addRoute
     */
    public function testAddRoute(): void
    {
        $this->routeCollector->addRoute(['GET'], '/users/{id}', 'UsersController:show');
        $this->assertEquals(require __DIR__ . '/data/single_route_results.php', $this->routeCollector->getData());
    }
}
