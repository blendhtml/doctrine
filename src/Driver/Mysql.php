<?php

declare(strict_types=1);

namespace Blendhtml\Doctrine\Driver;

use InvalidArgumentException;

final readonly class Mysql
{
    public function __construct(
        public string $host,
        public string $database,
        public string $username,
        public string $password,
        public int $port = 3306,
        public string $charset = 'utf8mb4',
    ) {
        if ($host === '') {
            throw new InvalidArgumentException(
                'MySQL host cannot be empty.'
            );
        }

        if ($database === '') {
            throw new InvalidArgumentException(
                'MySQL database cannot be empty.'
            );
        }

        if ($username === '') {
            throw new InvalidArgumentException(
                'MySQL username cannot be empty.'
            );
        }

        if ($port < 1 || $port > 65535) {
            throw new InvalidArgumentException(
                'MySQL port must be between 1 and 65535.'
            );
        }

        if ($charset === '') {
            throw new InvalidArgumentException(
                'MySQL charset cannot be empty.'
            );
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function connectionParams(): array
    {
        return [
            'driver' => 'pdo_mysql',
            'host' => $this->host,
            'port' => $this->port,
            'dbname' => $this->database,
            'user' => $this->username,
            'password' => $this->password,
            'charset' => $this->charset,
        ];
    }
}