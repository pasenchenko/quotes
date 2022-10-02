<?php

return [
    'channels' => [
        'telegram' => [
            'formFieldName' => 'nickname',
            'request' => App\Http\Requests\Share\TelegramRequest::class,
            'job' => App\Jobs\Share\ShareViaTelegram::class
        ],
        'email' => [
            'formFieldName' => 'email',
            'request' => App\Http\Requests\Share\EmailRequest::class,
            'job' => App\Jobs\Share\ShareViaEmail::class
        ],
        'viber' => [
            'formFieldName' => 'phone',
            'request' => App\Http\Requests\Share\ViberRequest::class,
            'job' => App\Jobs\Share\ShareViaViber::class
        ],
    ]
];