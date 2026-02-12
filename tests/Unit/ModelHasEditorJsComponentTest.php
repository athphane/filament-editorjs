<?php

use Athphane\FilamentEditorjs\Tests\TestSupport\Models\Post;

it('can get editorjs media collection name', function () {
    $post = new Post();

    expect($post->editorjsMediaCollectionName())->toBe('content_images');
});

it('can get editorjs content field name', function () {
    $post = new Post();

    expect($post->editorJsContentFieldName())->toBe('content');
});
