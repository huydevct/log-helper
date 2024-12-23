<?php
return [
    'log' => [
        'driver' => env("HELPER_LOG_DRIVER", 'telegram'),
        'enable' => env("HELPER_LOG_ENABLE", true),
        'name_queue' => env('HELPER_LOG_QUEUE_NAME', 'send-log'),
        'connections' => [
            'telegram' =>[
                'bot_token' => env("TELEGRAM_BOT_TOKEN"),
                'log_channel_id' => env("TELEGRAM_CHANNEL_LOG_ID"),
                'error_channel_id' => env("TELEGRAM_CHANNEL_ERROR_ID")
            ]
        ]
    ]
];