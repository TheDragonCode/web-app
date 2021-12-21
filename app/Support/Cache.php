<?php

declare(strict_types=1);

namespace App\Support;

use DragonCode\Cache\Services\Cache as DragonCache;
use DragonCode\Contracts\DataTransferObject\DataTransferObject;

class Cache
{
    public function remember(callable $callback, DataTransferObject $keys, string|int|callable|null $ttl = null): mixed
    {
        return DragonCache::make()
            ->tags($this->name())
            ->key($this->name(), $keys)
            ->ttl($ttl)
            ->put($callback);
    }

    protected function name(): string
    {
        return config('app.name');
    }
}
