<?php declare(strict_types=1);

namespace AnnotationRoute;

use FastRoute\DataGenerator;
use FastRoute\RouteParser;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use SplFileInfo;

class Collector
{
    /** @var string Pattern to match URIs within a DocComment */
    private const URI_PATTERN = '/(?<method>\bGET\b|\bPOST\b|\bDELETE\b|\bHEAD\b|\bPUT\b|\bUPDATE\b|\bPATCH\b)\s+(?<path>[\S]+)\s+(?<name>[A-z0-9_]*)/';

    /** @var RouteParser */
    private $routeParser;

    /** @var DataGenerator */
    private $dataGenerator;

    /** @var string */
    private $currentGroupPrefix;

    /**
     * Constructs a route collector.
     *
     * @param RouteParser   $routeParser
     * @param DataGenerator $dataGenerator
     */
    public function __construct(RouteParser $routeParser, DataGenerator $dataGenerator)
    {
        $this->routeParser = $routeParser;
        $this->dataGenerator = $dataGenerator;
        $this->currentGroupPrefix = '';
    }

    /**
     * Import all routes defined in a given path
     *
     * @param string $path        Path to search for routes
     * @param string $namespace   The namespace for the given path
     * @param string $filePostfix A file postfix to filter php files by
     *
     * @return Collector
     * @throws ReflectionException
     */
    public function addRoutesInPathWithNamespace(string $path, string $namespace, string $filePostfix = ''): self
    {
        $path = $this->normalisePath($path);
        if (!is_dir($path)) {
            throw new InvalidArgumentException('No valid directoy path given.');
        }

        $files = new RecursivePhpFileIterator($path, $filePostfix);

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $this->addRoutesForClass($this->getFileNamespace($file, $path, $namespace) . $file->getBasename('.php'));
        }

        return $this;
    }

    /**
     * Import all routes from a given controller, by it's fully qualified class name
     *
     * @param string $fullyQualifiedClassName
     * @return Collector
     * @throws ReflectionException
     */
    public function addRoutesForClass(string $fullyQualifiedClassName): self
    {
        try {
            $publicMethods = (new ReflectionClass($fullyQualifiedClassName))
                ->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($publicMethods as $method) {
                $this->registerRoutesForMethod($method);
            }
        } catch (ReflectionException $e) {
        }

        return $this;
    }

    /**
     * Adds a route to the collection.
     *
     * The syntax used in the $route string depends on the used route parser.
     *
     * @param string[] $httpMethods
     * @param string   $route
     * @param mixed    $handler
     */
    public function addRoute(array $httpMethods, $route, $handler): void
    {
        $route = $this->currentGroupPrefix . $route;
        $routeData = $this->routeParser->parse($route);

        foreach ($httpMethods as $method) {
            foreach ($routeData as $data) {
                $this->dataGenerator->addRoute($method, $data, $handler);
            }
        }
    }

    /**
     * Returns the collected route data, as provided by the data generator.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->dataGenerator->getData();
    }

    /**
     * Registers the defined routes within a doc comment for a given method
     *
     * @param ReflectionMethod $method
     */
    private function registerRoutesForMethod(ReflectionMethod $method): void
    {
        $docComment = $method->getDocComment();
        if (!$docComment) {
            return;
        }

        $matches = [];
        preg_match_all(self::URI_PATTERN, $docComment, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $this->addRoute(
                [$match['method']],
                $match['path'],
                $method->getDeclaringClass()->getName() . ':' . $method->getName()
            );
        }
    }

    /**
     * @param string $path
     * @return string
     */
    private function normalisePath(string $path): string
    {
        if (substr($path, -1) !== '/') {
            $path .= '/';
        }
        return $path;
    }

    /**
     * Creates the namespace for a given file
     *
     * @param SplFileInfo $file
     * @param string      $path
     * @param string      $namespace
     *
     * @return string
     */
    private function getFileNamespace(SplFileInfo $file, string $path, string $namespace): string
    {
        list($tmpRoutePath, $tmpFilepath) = str_replace('/', '\\', [$path, ($file->getPath() . '\\')]);
        return str_replace($tmpRoutePath, $namespace, $tmpFilepath) . '\\';
    }
}
