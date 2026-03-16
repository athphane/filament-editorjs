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
        'pro' => [
            'header', 'image', 'delimiter', 'list', 'underline', 'quote', 'table',
            'raw', 'code', 'inline-code', 'style', 'checklist',
        ],
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

    /**
     * Reading time configuration.
     */
    'reading_time' => [
        'words_per_minute' => 225,
    ],

    /**
     * Code block configuration.
     */
    'code' => [
        'default_theme'        => 'github-light',
        'line_highlighting'    => true,
        'supported_line_modes' => ['highlight', 'add', 'delete', 'focus'],
    ],
];
