<?php

declare(strict_types=1);

namespace App\Facades;

use App\Support\Cache as Support;
use DragonCode\Contracts\DataTransferObject\DataTransferObject;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed remember(callable $callback, DataTransferObject $keys, string|int|callable|null $ttl = null)
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
