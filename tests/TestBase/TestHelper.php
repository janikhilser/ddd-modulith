<?php

declare(strict_types=1);

namespace App\Tests\TestBase;

use Exception;
use PDO;
use PDOException;

class TestHelper
{
    /**
     * @throws Exception
     */
    public static function isTestDbAvailable(): bool
    {
        $connectionString = $_ENV['DATABASE_URL_COMMON'];
        $pattern = '/mysql:\/\/([^:]+):([^@]+)@([^\/]+)/';
        preg_match($pattern, $connectionString, $matches);

        try {
            new PDO("mysql:host=$matches[3];charset=utf8mb4", $matches[1]);

            return true;
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            if (1045 == $errorCode) {
                return true;
            } elseif (2002 == $errorCode) {
                return false;
            }
            throw new Exception("ErrorCode '$errorCode' not implemented.");
        }
    }

    /**
     * @return array<string>
     */
    public static function getDatabases(): array
    {
        $prefix = 'DATABASE_URL_';
        $prefixLength = strlen($prefix);
        $envVariables = [];

        foreach ($_ENV as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $keyWithoutPrefix = strtolower(substr($key, $prefixLength));
                $envVariables[] = $keyWithoutPrefix;
            }
        }

        return $envVariables;
    }

    public static function dropDatabaseIfExists(string $database): void
    {
        passthru(sprintf(
            'APP_ENV=%s php "%s/../../bin/console"  doctrine:database:drop --connection='.$database.' -f -q',
            $_ENV['APP_ENV'],
            __DIR__
        ));
    }

    public static function createDatabase(string $database): void
    {
        passthru(sprintf(
            'APP_ENV=%s php "%s/../../bin/console"  doctrine:database:create --connection='.$database.' -q',
            $_ENV['APP_ENV'],
            __DIR__
        ));
    }

    public static function migrate(string $database): void
    {
        passthru(sprintf(
            'APP_ENV=%s php "%s/../../bin/console"  doctrine:migration:migrate --no-interaction --em='.$database,
            $_ENV['APP_ENV'],
            __DIR__
        ));
    }

    public static function createSchema(string $database): void
    {
        passthru(sprintf(
            'APP_ENV=%s php "%s/../../bin/console"  doctrine:schema:create --em='.$database.' -q',
            $_ENV['APP_ENV'],
            __DIR__
        ));
    }

    public static function loadFixtures(string $database): void
    {
        passthru(sprintf(
            'APP_ENV=%s php "%s/../../bin/console" doctrine:fixtures:load --group='.ucfirst(self::replaceAndFormatDatabaseToClassname($database)).'Fixtures --em='.$database.' -n -q',
            $_ENV['APP_ENV'],
            __DIR__
        ));
    }

    private static function replaceAndFormatDatabaseToClassname(string $input): string
    {
        $output = preg_replace_callback(
            '/_([a-z])/',
            function ($matches) {
                return strtoupper($matches[1]);
            },
            $input
        );

        $output = preg_replace('/_([0-9])/', '$1', $output);

        return ucfirst($output);
    }
}
