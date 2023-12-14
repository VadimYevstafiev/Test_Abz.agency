<?php

return [
    'user' => [
        'seeder' => ['count_rows' => 45],
        'avatar' => [
            'dir' => 'users/avatars',
            'file' => [
                'ext' => 'jpg',
                'width' => 70,
                'height' => 70
            ],
        ],
        'index' => ['count_rows' => 6],
        'visible properties' => ['name', 'surname', 'birthdate', 'avatar', 'email']
    ],
];
