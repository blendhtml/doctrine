<?php

declare(strict_types=1);

namespace Blendhtml\Doctrine;

final readonly class OrmConfig
{
    /**
     * @param list<string> $entityPaths
     */
    public function __construct(
        public array $entityPaths = [
            __DIR__ . '/src/Entity',
        ],
        public bool $devMode = true, // @todo Read from .env file
    ) {
    }
}