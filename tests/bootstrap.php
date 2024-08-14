<?php

declare(strict_types=1);

use App\Tests\TestBase\TestHelper;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if (TestHelper::isTestDbAvailable()) {
    // Alle Namen der Datenbanken aus dem Env-File extrahieren
    $databases = TestHelper::getDatabases();

    foreach ($databases as $database) {
        TestHelper::dropDatabaseIfExists($database);
        if ('test_database_not_existing' == $database) {
            continue;
        }

        TestHelper::createDatabase($database);

        if ('legacy' == $database) {
            continue;
        }

        if (str_starts_with($database, 'test')) {
            TestHelper::createSchema($database);
        } else {
            TestHelper::migrate($database);
        }

        TestHelper::loadFixtures($database);
    }
} else {
    echo "\033[31mBitte fahren sie die Test-Datenbank mit docker-compose im Verzeichnis '\\tests' hoch, um alle Tests auszuführen!\n\n\033[0m";
}
