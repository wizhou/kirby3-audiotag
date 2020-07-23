<?php

Kirby::plugin('wizhou/kirby3-audiotag', [
    'translations' => [
        'en' => require_once __DIR__ . '/languages/en.php',
        'fr' => require_once __DIR__ . '/languages/fr.php',
    ],
    'tags' => [
        'audio' => require_once __DIR__ . '/tags/audio.php',
    ]
]);
