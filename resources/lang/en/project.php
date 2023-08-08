<?php

return [
    // ...

    'unavailable_audits' => 'No Article Audits available',

    'created' =>[
        'modified' => [
            'name' => 'Plan has been created with name: <strong>:new</strong>',
        ],
    ],

    'updated'            => [
        'metadata' => 'On :audit_created_at, :user_username [:audit_ip_address] updated this record via :audit_url',
        'modified' => [
            'name' => 'The Plan Name has been modified from <strong>:old</strong> to <strong>:new</strong>'
        ],
    ],

    // ...
];
