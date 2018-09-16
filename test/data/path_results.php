<?php

return [
    0 => [
            'GET' => [
                    '/about_us'  => 'Tests\\AnnotationRoute\\Fixtures\\HomeController:index',
                    '/users'     => 'Tests\\AnnotationRoute\\Fixtures\\UsersController:index',
                    '/users/new' => 'Tests\\AnnotationRoute\\Fixtures\\UsersController:new',
                    '/'          => 'Tests\\AnnotationRoute\\Fixtures\\Base:index',
                ],
        ],
    1 => [
            'GET'    => [
                    0 => [
                            'regex'    => '~^(?|/users/(\\d+)|/users/(\\d+)/edit())$~',
                            'routeMap' => [
                                    2 => [
                                            0 => 'Tests\\AnnotationRoute\\Fixtures\\UsersController:show',
                                            1 => [
                                                    'id' => 'id',
                                                ],
                                        ],
                                    3 => [
                                            0 => 'Tests\\AnnotationRoute\\Fixtures\\UsersController:edit',
                                            1 => [
                                                    'id' => 'id',
                                                ],
                                        ],
                                ],
                        ],
                ],
            'PUT'    => [
                    0 => [
                            'regex'    => '~^(?|/users/(\\d+)/edit)$~',
                            'routeMap' => [
                                    2 => [
                                            0 => 'Tests\\AnnotationRoute\\Fixtures\\UsersController:update',
                                            1 => [
                                                    'id' => 'id',
                                                ],
                                        ],
                                ],
                        ],
                ],
            'PATCH'  => [
                    0 => [
                            'regex'    => '~^(?|/users/(\\d+)/edit/)$~',
                            'routeMap' => [
                                    2 => [
                                            0 => 'Tests\\AnnotationRoute\\Fixtures\\UsersController:update',
                                            1 => [
                                                    'id' => 'id',
                                                ],
                                        ],
                                ],
                        ],
                ],
            'POST'   => [
                    0 => [
                            'regex'    => '~^(?|/users/(\\d+)/)$~',
                            'routeMap' => [
                                    2 => [
                                            0 => 'Tests\\AnnotationRoute\\Fixtures\\UsersController:create',
                                            1 => [
                                                    'id' => 'id',
                                                ],
                                        ],
                                ],
                        ],
                ],
            'DELETE' => [
                    0 => [
                            'regex'    => '~^(?|/users/(\\d+))$~',
                            'routeMap' => [
                                    2 => [
                                            0 => 'Tests\\AnnotationRoute\\Fixtures\\UsersController:delete',
                                            1 => [
                                                    'id' => 'id',
                                                ],
                                        ],
                                ],
                        ],
                ],
        ],
];
