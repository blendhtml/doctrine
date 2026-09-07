<?php

declare(strict_types=1);

namespace Blendhtml\Doctrine\Driver;

use InvalidArgumentException;

final readonly class Postgres
{
    public function __construct(
        public string $host,
        public string $database,
        public string $username,
        public string $password,
        public int $port = 5432,
    ) {
        if ($host === '') {
            throw new InvalidArgumentException(
                'PostgreSQL host cannot be empty.'
            );
        }

        if ($database === '') {
            throw new InvalidArgumentException(
                'PostgreSQL database cannot be empty.'
            );
        }

        if ($username === '') {
            throw new InvalidArgumentException(
                'PostgreSQL username cannot be empty.'
            );
        }

        if ($port < 1 || $port > 65535) {
            throw new InvalidArgumentException(
                'PostgreSQL port must be between 1 and 65535.'
            );
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function connectionParams(): array
    {
        return [
            'driver' => 'pdo_pgsql',
            'host' => $this->host,
            'port' => $this->port,
            'dbname' => $this->database,
            'user' => $this->username,
            'password' => $this->password,
        ];
    }
}