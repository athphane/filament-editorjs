# Filament EditorJS Package

## Overview

Filament EditorJS is a Laravel package that provides an EditorJS field for the Filament admin panel. It integrates with Spatie's Media Library package for image uploads and supports various EditorJS tools.

## Key Features

1. **EditorJS Integration**: Provides a rich text editor field for Filament forms using EditorJS
2. **Image Upload Support**: Integrates with Spatie's Media Library for handling image uploads
3. **Tool Profiles**: Supports configurable tool profiles (default and pro)
4. **Livewire File Uploads**: Uses Filament's `HasFileAttachments` for handling image uploads
5. **Model Trait**: Provides `ModelHasEditorJsComponent` trait for easy model integration
6. **Responsive Design**: Works well with Filament's admin panel styling

## Package Structure

```
src/
├── Facades/
├── Forms/
│   ├── Components/
│   │   └── EditorjsTextField.php
│   └── Concerns/
│       ├── HasHeight.php
│       └── HasTools.php
├── Testing/
│   └── TestsFilamentEditorjs.php
├── Traits/
│   └── ModelHasEditorJsComponent.php
├── FilamentEditorjs.php
├── FilamentEditorjsPlugin.php
└── FilamentEditorjsServiceProvider.php
```

## Main Components

### EditorjsTextField

The main form component that renders the EditorJS editor in Filament forms. It extends Filament's Field class and implements HasFileAttachments contract.

Key features:
- Uses Blade view for rendering
- Integrates with Livewire for file uploads
- Supports configurable tools/profiles
- Includes height customization
- Provides placeholder support

### ModelHasEditorJsComponent Trait

A trait that should be used in models to integrate with the EditorJS field. It provides:

- Media collection registration for images
- Media conversion setup
- Automatic cleanup of unused media
- Helper methods for saving images from temporary files

### Configuration

The package can be configured through `config/filament-editorjs.php`:

- Tool profiles (default and pro)
- Default profile selection
- Allowed image MIME types

## Usage

1. **Installation**: 
   ```bash
   composer require athphane/filament-editorjs
   ```

2. **Model Setup**:
   - Add `HasMedia` interface and `InteractsWithMedia` trait from Spatie's Media Library
   - Use `ModelHasEditorJsComponent` trait
   - Implement `registerMediaCollections()` and `registerMediaConversions()` methods

3. **Form Field Usage**:
   ```php
   public static function form(Form $form): Form
   {
       return $form
           ->schema([
               EditorjsTextField::make('content')
                   ->placeholder('Start writing...'),
           ]);
   }
   ```

## Version 2.0 Changes

- Uses Livewire-based file uploads via Filament's `HasFileAttachments`
- Removed custom upload endpoints and controller
- Updated to work with Filament 3.3+ and Spatie Media Library plugin
- Improved client-side file validation

## Frontend Implementation

The package uses Alpine.js for the frontend integration:
- EditorJS is initialized as an Alpine component
- Supports various EditorJS tools (header, image, list, etc.)
- Includes drag and drop functionality
- Handles image uploads through Livewire

## Build Process

The package uses:
- TailwindCSS for styling
- ESBuild for JavaScript bundling
- PostCSS for CSS processing
- Development and production build scripts

## Testing

The package includes basic PestPHP tests and follows Filament's testing conventions.