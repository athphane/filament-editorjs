# Upgrade Guide

## Upgrading from 1.x to 2.0

1. Update your composer dependencies:
   - Require `filament/filament` version `^3.3`.
   - Replace direct usage of `spatie/laravel-medialibrary` with `filament/spatie-laravel-media-library-plugin`.
2. Remove the image upload routes and controller:
   - The `FilamentEditorJsController` and its routes have been deleted.
   - The `HasImageUploadEndpoints` trait and related methods such as `setDefaultUploadUrl()` are no longer used.
3. File uploads are now handled through Livewire's `HasFileAttachments`:
   - Ensure your models still use the `ModelHasEditorJsComponent` trait and register the necessary media collections and conversions.
   - If you previously overrode `editorJsSaveImageFromRequest`, rename your method to `editJsSaveImageFromTempFile(TemporaryUploadedFile $file)`.
4. The upload response now returns both the image URL and media ID. Update any code that processes uploaded image data accordingly.

