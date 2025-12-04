<?php

namespace Athphane\FilamentEditorjs;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentEditorjsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-editorjs';

    public static string $viewNamespace = 'filament-editorjs';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('athphane/filament-editorjs');
            });

        if (file_exists($package->basePath('/../config/filament-editorjs.php'))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-editorjs/{$file->getFilename()}"),
                ], 'filament-editorjs-stubs');
            }
        }
    }

    protected function getAssetPackageName(): ?string
    {
        return 'athphane/filament-editorjs';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-editorjs', __DIR__ . '/../resources/dist/components/filament-editorjs.js'),
            Css::make('filament-editorjs-styles', __DIR__ . '/../resources/dist/filament-editorjs.css'),
            Js::make('filament-editorjs-scripts', __DIR__ . '/../resources/dist/filament-editorjs.js'),
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }
}
