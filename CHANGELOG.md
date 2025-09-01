# Changelog

All notable changes to `filament-editorjs` will be documented in this file.

## 2.0.0 - 2025-09-01
### Added
- Livewire-based file uploads for the Editor.js field using Filament's `HasFileAttachments`.
- Image upload responses now include both the file URL and media ID.

### Changed
- Requires `filament/filament` `^3.3` and `filament/spatie-laravel-media-library-plugin`.
- `ModelHasEditorJsComponent` now saves `TemporaryUploadedFile` instances via `editJsSaveImageFromTempFile`.
- Improved Editor.js client script with file type and size validation.

### Removed
- `HasImageUploadEndpoints` trait and `FilamentEditorJsController`; custom upload routes are no longer needed.

## 1.0.0 - 202X-XX-XX

- initial release
