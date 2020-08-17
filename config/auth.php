<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],

        'organizer' => [
            'driver' => 'jwt',
            'provider' => 'organizers',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\User::class
        ],

        'organizers' => [
            'driver' => 'eloquent',
            'model' => \App\Organizer::class
        ]
    ]
];