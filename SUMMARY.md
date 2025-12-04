# Filament EditorJS Package Summary

## Overview
Filament EditorJS is a Laravel package that provides an EditorJS field for the Filament admin panel. It integrates with Spatie's Media Library package for image uploads and supports various EditorJS tools.

## Key Components

### 1. Main Field Component
- `EditorjsTextField`: The main form component that renders EditorJS in Filament forms
- Extends Filament's Field class and implements HasFileAttachments contract
- Uses Blade view (`editorjs-text-field.blade.php`) for rendering
- Supports configurable tools/profiles, height customization, and placeholders

### 2. Trait for Models
- `ModelHasEditorJsComponent`: Trait for models that require EditorJS integration
- Provides media collection registration for images
- Handles automatic cleanup of unused media
- Includes helper methods for saving images from temporary files

### 3. Service Provider
- `FilamentEditorjsServiceProvider`: Registers CSS and JS assets and manages package configuration
- Used to register the assets with Filament's asset system

### 4. Plugin Class
- `FilamentEditorjsPlugin`: Plugin implementation for Filament panel integration

## Asset Management

### Previous Implementation (Global Registration)
- CSS and JS assets were registered globally in the service provider
- Assets automatically loaded on all pages where the Filament panel was used
- Asset registration code in `FilamentEditorjsServiceProvider::getAssets()`:
  ```php
  Css::make('filament-editorjs-styles', __DIR__ . '/../resources/dist/filament-editorjs.css'),
  Js::make('filament-editorjs-scripts', __DIR__ . '/../resources/dist/filament-editorjs.js'),
  ```

### New Implementation (On-Demand Loading)
- Assets are loaded using `x-load-css` and `x-load-js` directives in the Blade template
- Only loads assets when the EditorJS field is actually present on the page
- Uses Filament's dynamic asset loading functionality

#### Blade Template Implementation
The template includes these attributes for on-demand loading:
```blade
x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('filament-editorjs-styles', package: 'athphane/filament-editorjs'))]"
x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('filament-editorjs-scripts', package: 'athphane/filament-editorjs'))]"
x-data="editorjs({...})"
```

## Current Issue with On-Demand Loading

### Problem
When switching to on-demand loading, an "Alpine Expression Error: editorjs is not defined" occurs.

### Root Cause
- `x-load-js` loads the JavaScript asynchronously
- `x-data="editorjs({})"` executes immediately during Alpine initialization
- The `editorjs` Alpine component definition is not available when `x-data` executes
- There's no synchronization between script loading and component initialization

### Solution Approach
The issue requires implementing a mechanism to ensure the JavaScript containing the Alpine component definition is loaded before the component is initialized. This typically involves using Alpine's lifecycle features or creating a wrapper that waits for the script to load.