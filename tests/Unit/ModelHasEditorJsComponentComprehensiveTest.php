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

it('can register editorjs media collections with default mime types', function () {
    $post = new Post();

    expect($post->registerEditorJsMediaCollections())->toBeNull();
});

it('can register editorjs media collections with custom mime types', function () {
    $post = new Post();

    $mimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

    expect($post->registerEditorJsMediaCollections($mimeTypes))->toBeNull();
});

it('can register editorjs media collections with responsive images disabled', function () {
    $post = new Post();

    expect($post->registerEditorJsMediaCollections(null, false))->toBeNull();
});

it('can register editorjs media conversions', function () {
    $post = new Post();

    expect($post->registerEditorJsMediaConversions())->toBeNull();
});

it('can register editorjs media conversions without media object', function () {
    $post = new Post();

    expect($post->registerEditorJsMediaConversions())->toBeNull();
});
