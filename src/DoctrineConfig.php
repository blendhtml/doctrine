<?php

declare(strict_types=1);

namespace Blendhtml\Doctrine;

use Blendhtml\Doctrine\Driver\Mysql;
use Blendhtml\Doctrine\Driver\Postgres;
use Blendhtml\Doctrine\Driver\Sqlite;

final readonly class DoctrineConfig
{
    public function __construct(
        public Sqlite|Mysql|Postgres $driver,
        public OrmConfig             $orm = new OrmConfig(),
    )
    {
    }

    public static function default(): self
    {
        return new self(
            driver: new Sqlite(
                path: dirname(__DIR__, 4) . '/database.sqlite',
            ),
        );
    }
}