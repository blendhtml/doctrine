<?php

declare(strict_types=1);

namespace Blendhtml\Doctrine;

use Blendhtml\Doctrine\Driver\Mysql;
use Blendhtml\Doctrine\Driver\Postgres;
use Blendhtml\Doctrine\Driver\Sqlite;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use LogicException;

final class Doctrine
{
    private static ?DoctrineConfig $config = null;

    private static ?EntityManagerInterface $entityManager = null;

    public static function configure(
        DoctrineConfig $config,
    ): void {
        if (self::$entityManager !== null) {
            throw new LogicException(
                'Database configuration cannot be changed after the EntityManager has been created.'
            );
        }

        self::$config = $config;
    }

    public static function em(
        ?DoctrineConfig $config = null,
    ): EntityManagerInterface {
        if (self::$entityManager !== null) {
            return self::$entityManager;
        }

        $config ??= self::$config ?? DoctrineConfig::default();

        $ormConfig = ORMSetup::createAttributeMetadataConfiguration(
            paths: $config->orm->entityPaths,
            isDevMode: $config->orm->devMode,
        );

        $connection = DriverManager::getConnection(
            $config->driver->connectionParams(),
        );

        self::configureConnection(
            $connection,
            $config->driver,
        );

        return self::$entityManager = new EntityManager(
            $connection,
            $ormConfig,
        );
    }

    private static function configureConnection(
        Connection $connection,
        Sqlite|Mysql|Postgres $database,
    ): void {
        if (!$database instanceof Sqlite) {
            return;
        }

        $connection->executeStatement(
            'PRAGMA foreign_keys = ON',
        );

        $connection->executeStatement(
            'PRAGMA journal_mode = WAL',
        );

        $connection->executeStatement(
            'PRAGMA busy_timeout = 5000',
        );
    }

    public static function reset(): void
    {
        self::$entityManager = null;
        self::$config = null;
    }

    private function __construct()
    {
    }
}