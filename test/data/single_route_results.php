<?php

return [
    0 => [],
    1 => [
            'GET' => [
                    0 => [
                            'regex'    => '~^(?|/users/([^/]+))$~',
                            'routeMap' => [
                                    2 => [
                                            0 => 'UsersController:show',
                                            1 => [
                                                    'id' => 'id',
                                                ],
                                        ],
                                ],
                        ],
                ],
        ],
];
