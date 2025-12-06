# Rendering EditorJS Content

The Filament EditorJS package now includes a robust rendering system that allows you to easily display EditorJS content on your website with Tailwind styling.

## Basic Usage

### Using the Main Package Class

```php
use Athphane\FilamentEditorjs\FilamentEditorjs;

// In your controller or wherever you need to render the content
$content = '{"time":1689427598038,"blocks":[{"data":{"message":"Hello World"},"type":"paragraph"}],"version":"2.27.2"}';
$output = FilamentEditorjs::renderContent($content);
echo $output;
```

### Using the Facade (if you have registered it in config/app.php)

```php
use FilamentEditorjs;

// If you've added the facade to config/app.php aliases
$content = '{"time":1689427598038,"blocks":[{"data":{"message":"Hello World"},"type":"paragraph"}],"version":"2.27.2"}';
$output = FilamentEditorjs::renderContent($content);
echo $output;
```

### Using the Component Static Method

```php
use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;

$content = '{"time":1689427598038,"blocks":[{"data":{"message":"Hello World"},"type":"paragraph"}],"version":"2.27.2"}';
$output = EditorjsTextField::renderContent($content);
echo $output;
```

## Customization Options

You can customize the rendering by passing configuration options:

```php
$config = [
    'wrapper_template' => 'custom.wrapper.view',  // Override the wrapper template
    'container_classes' => 'my-custom-classes',  // Classes for the main container
];

$output = EditorjsHelper::render($content, $config);
```

## Adding Custom Plugins and Renderers

There are two separate configuration steps:

### 1. Adding Renderers (AppServiceProvider)

Configure renderers in your `app/Providers/AppServiceProvider.php`. These handle the display of custom blocks on the frontend:

```php
use Athphane\FilamentEditorjs\FilamentEditorjs;
use Athphane\FilamentEditorjs\Renderers\BlockRenderer;

class CustomBlockRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $content = $data['content'] ?? '';

        return view('renderers.custom-block', [
            'content' => $this->escape($content),
        ])->render();
    }

    public function getType(): string
    {
        return 'custom-block-type';
    }
}

// In your AppServiceProvider's boot method:
public function boot()
{
    // Add your custom renderer
    FilamentEditorjs::addRenderer(new CustomBlockRenderer());
}
```

### 2. Adding Editor Plugins (Per Form Field)

Add plugins to your EditorJS fields in your forms, where you can use dynamic configuration:

```php
use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;

EditorjsTextField::make('content')
    ->addPlugin('linkTool', [
        'endpoint' => route('editorjs.link-tool-parser'), // Dynamic route generation works here
    ])
    ->addPlugin('custom-block-type', [
        // Any custom configuration for the editor plugin
    ])
    ->placeholder('Start writing...'),
```

This approach provides:
1. Global renderer configuration in AppServiceProvider
2. Dynamic plugin configuration per field where route() and other request-time functions work
3. Clean separation of concerns
4. Full flexibility for complex plugin configurations
```

## Service Provider Integration

The renderer service is automatically registered with the main service provider, so no additional configuration is needed. The rendering functionality is available as soon as the main package is installed and registered.

## Supported Block Types

The package ships with renderers for the following block types:

- `paragraph` - Standard text paragraphs
- `header` - Headers of different levels
- `image` - Images with captions and styling options
- `list` - Ordered and unordered lists
- `quote` - Block quotes with citations
- `code` - Code blocks with syntax highlighting
- `table` - Tables with rows and columns
- `delimiter` - Horizontal dividers
- `raw` - Raw HTML content
- `inline-code` - Inline code snippets
- `checklist` - Interactive checklists

Each block type is rendered with appropriate Tailwind CSS classes for consistent styling.