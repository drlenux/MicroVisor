<?php

return [
    'timeout' => 0.1,
    'services' => [
        'sleep-1' => [
            'cmd' => 'sleep 1',
            'thread' => 3,
            'timeout' => 2
        ],
        'sleep-2' => [
            'cmd' => 'sleep 2',
            'thread' => 5,
            'timeout' => 5
        ],
        'while' => [
            'cmd' => 'sleep 5000000'
        ]
    ]
];