<?php

namespace ChrisKelemba\LaravelUiKit\Providers;

use ChrisKelemba\LaravelUiKit\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LaravelUiKitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/ui-kit.php', 'ui-kit');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'ui-kit');
        $this->registerAssetRoutes();

        Paginator::defaultView(config('ui-kit.pagination.view', 'ui-kit::pagination'));

        $prefix = config('ui-kit.component_prefix', 'ui-kit');
        Blade::anonymousComponentPath(__DIR__ . '/../../resources/views/components', $prefix);
        Blade::componentNamespace('ChrisKelemba\\LaravelUiKit\\View\\Components', $prefix);

        foreach ($this->discoverComponentClasses() as $component) {
            Blade::component($component['class'], $prefix . '-' . $component['alias']);
        }

        $autocrudViews = __DIR__ . '/../../resources/views/autocrud';

        if (is_dir($autocrudViews)) {
            View::prependNamespace('autocrud', $autocrudViews);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/ui-kit.php' => config_path('ui-kit.php'),
            ], 'ui-kit-config');

            $this->publishes([
                __DIR__ . '/../../resources/views' => resource_path('views/vendor/ui-kit'),
            ], 'ui-kit-views');

            $this->publishes([], 'ui-kit-assets');
        }
    }

    protected function registerAssetRoutes(): void
    {
        Route::get('ui-kit/assets/ui-kit.css', [AssetController::class, 'css'])
            ->name('ui-kit.assets.css');

        Route::get('ui-kit/assets/media', [AssetController::class, 'media'])
            ->name('ui-kit.assets.media');
    }

    /**
     * @return array<int, array{class: string, alias: string}>
     */
    protected function discoverComponentClasses(): array
    {
        $componentPath = __DIR__ . '/../../resources/views/components';
        $components = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($componentPath));

        foreach ($iterator as $file) {
            if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            $relativePath = substr($file->getPathname(), strlen($componentPath) + 1);
            $relativeName = substr($relativePath, 0, -10);
            $segments = explode(DIRECTORY_SEPARATOR, $relativeName);
            $componentName = array_pop($segments);

            $classSegments = array_map([$this, 'studlyComponentSegment'], $segments);
            $className = $this->studlyComponentSegment($componentName);
            $namespace = 'ChrisKelemba\\LaravelUiKit\\View\\Components';

            if ($classSegments !== []) {
                $namespace .= '\\' . implode('\\', $classSegments);
            }

            $components[] = [
                'class' => $namespace . '\\' . $className,
                'alias' => $this->kebabComponentSegment($componentName),
            ];
        }

        return $components;
    }

    protected function studlyComponentSegment(string $value): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value)));
    }

    protected function kebabComponentSegment(string $value): string
    {
        return strtolower(str_replace('_', '-', $value));
    }
}
