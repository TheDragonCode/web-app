<?php

declare(strict_types=1);

namespace App\Providers;

use App\Constants\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class BladeServiceProvider extends ServiceProvider
{
    protected string $namespace_suffix = 'View\\Components';

    public function boot()
    {
        if ($this->has()) {
            $this->bootComponent();
        }
    }

    protected function bootComponent()
    {
        Blade::componentNamespace(
            $this->getNamespace(),
            $this->getAppName()
        );
    }

    protected function has(): bool
    {
        return file_exists(
            base_path('app/View')
        );
    }

    protected function getNamespace(): string
    {
        return $this->getNamespacePrefix() . '\\' . $this->getNamespaceSuffix();
    }

    protected function getNamespacePrefix(): string
    {
        $prepare = dirname(__CLASS__);

        return str_replace('/', '\\', $prepare);
    }

    protected function getNamespaceSuffix(): string
    {
        return $this->namespace_suffix;
    }

    protected function getAppName(): string
    {
        return Str::lower(Application::NAME);
    }
}
