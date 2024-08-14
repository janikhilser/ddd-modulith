# README

This project is a template for a DDD-based Modulith. It uses Symfony and is fully Docker-compatible and can be executed directly with 
`docker compose up`. The modules are integrated via IntegrationEvents, which can be found in the extra Integration 
directory.

A rudimentary library application was implemented to illustrate this. This contains the two BoundedContexts `Search` and
`Loan`. Books can be added to `Search`, which then appear as a publication in `Loan`. Real books can then be purchased 
and borrowed in `Loan`.

Some useful commands for controlling the application and development are listed below.

**Build images**
```sh
docker compose build
```

**Start application**
```sh
docker compose up
```

**Install dependencies**
```sh
docker compose exec -T php composer install
```

**Execute messages interactive**
```sh
docker compose exec -iT php bin/console messenger:consume
```

**Stop application**
```sh
docker compose down
```

**Generate migration**
```console
docker compose exec -T php bin/console doctrine:migrations:diff --em=<EntityManager>
```
The database migrations are carried out automatically when the application is started

**Debugging**

1. Start application in xDebug-Mode
    ```sh
    XDEBUG_MODE=debug docker compose up -d
    ```
2. In the `Settings/Preferences` dialog, go to `PHP | Servers`
3. Create a new server:
    * Name: `symfony` (or whatever you want to use for the variable `PHP_IDE_CONFIG`)
    * Host: `localhost` (or the one defined using the `SERVER_NAME` environment variable)
    * Port: `443`
    * Debugger: `Xdebug`
    * Check `Use path mappings`
    * Absolute path on the server: `/app`
4. In PHPStorm, open the `Run` menu and click on `Start Listening for PHP Debug Connections`
5. Add the `?XDEBUG_SESSION=PHPSTORM` query parameter to the URL of the page you want to debug.

**Update the containerization-template**

1. Run the script to synchronize your project with the latest version of the skeleton:

    ```sh
    curl -sSL https://raw.githubusercontent.com/mano-lis/template-sync/main/template-sync.sh | sh -s -- https://github.com/dunglas/symfony-docker
    ```

2. Resolve conflicts, if any
3. Run `git cherry-pick --continue`

