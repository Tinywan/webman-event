<?php
return [
    'enable' => true,
    'event' => [
        // 事件监听
        'listener'    => [
            'LogWrite' => \Tinywan\Event\LogWrite::class,
        ],

        // 事件订阅器
        'subscriber' => [],
    ]
];