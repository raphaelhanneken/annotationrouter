<?php


namespace Tests\AnnotationRoute\Fixtures;


use BadMethodCallException;

class UsersController extends Base
{
    /**
     * GET /users
     */
    public function index(): void
    {
        throw new BadMethodCallException();
    }
    /**
     * GET /users/{id:\d+}
     */
    public function show(): void
    {
        throw new BadMethodCallException();
    }

    /**
     * GET /users/{id:\d+}/edit
     */
    public function edit(array $params): void
    {
        throw new BadMethodCallException();
    }

    /**
     * PUT /users/{id:\d+}/edit
     * PATCH /users/{id:\d+}/edit/
     */
    public function update(array $params): void
    {
        throw new BadMethodCallException();
    }

    /**
     * GET /users/new
     */
    public function new(): void
    {
        throw new BadMethodCallException();
    }

    /**
     * POST /users/{id:\d+}/
     */
    public function create(array $params): void
    {
        throw new BadMethodCallException();
    }

    /**
     * DELETE /users/{id:\d+}
     */
    public function delete(array $params): void
    {
        throw new BadMethodCallException();
    }

    /**
     * @param array $params
     */
    public function noRouteButPublic(array $params): void
    {
        throw new BadMethodCallException();
    }

    public function methodWithoutDocComment(): void
    {
        throw new BadMethodCallException();
    }

    /**
     * @param int $id
     */
    private function setUser(int $id): void
    {
        throw new BadMethodCallException();
    }
}
