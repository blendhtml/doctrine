<?php

declare(strict_types=1);

namespace Blendhtml\Doctrine\Driver;

use InvalidArgumentException;
use RuntimeException;

final readonly class Sqlite
{
    public function __construct(
        public string $path,
    )
    {
        if ($path === '') {
            throw new InvalidArgumentException(
                'SQLite database path cannot be empty.'
            );
        }

        $directory = dirname($this->path);

        if (is_dir($directory)) {
            return;
        }

        if (!mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException(
                sprintf('Unable to create SQLite directory: %s', $directory),
            );
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function connectionParams(): array
    {
        return [
            'driver' => 'pdo_sqlite',
            'path' => $this->path,
        ];
    }
}