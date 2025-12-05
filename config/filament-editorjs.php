<?php

// config for Athphane/FilamentEditorjs
return [
    /**
     * The profiles to use for the editorjs field.
     * The default profile is the default_profile from the config.
     */
    'profiles' => [
        'default' => [
            'header', 'image', 'delimiter', 'list', 'underline', 'quote', 'table',
            'raw', 'code', 'inline-code', 'style', 'checklist',
        ],
        // 'pro' => [
        //     'header', 'image', 'delimiter', 'list', 'underline', 'quote', 'table',
        //     'raw', 'code', 'inline-code', 'style',
        // ],
    ],

    /**
     * The default profile to use for the editorjs field.
     */
    'default_profile' => 'default',

    /**
     * The allowed image mime types for the editorjs field.
     */
    'image_mime_types' => [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/tiff',
        'image/x-citrix-png',
        'image/x-png',
        'image/svg+xml',
        'image/svg',
    ],
];
