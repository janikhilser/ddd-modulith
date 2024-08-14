#!/bin/sh
set -e

update_database(){
	entityManager=$1

	echo "Waiting for database '$entityManager' to be ready..."
    ATTEMPTS_LEFT_TO_REACH_DATABASE=60
    until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || DATABASE_ERROR=$(php bin/console app:is-database-available $entityManager 2>&1); do

    	if echo "$DATABASE_ERROR" | grep -q "Unknown database '$entityManager'"; then
            echo "The server is available, but the database '$entityManager' is not existing, why this is now being created."
            php bin/console doctrine:database:create --connection=$entityManager
            continue
        fi

      if ! echo "$DATABASE_ERROR" | grep -q "Connection could not be established."; then
        echo "$DATABASE_ERROR"
        exit 1
      fi

    	sleep 1
    	ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
    	echo "Still waiting for database '$entityManager' to be ready... Or maybe the database is not reachable. $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left."
    done

    if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
    	echo "The database '$entityManager' is not up or not reachable:"
    	echo "$DATABASE_ERROR"
    	exit 1
    else
    	echo "The database '$entityManager' is now ready and reachable"
    fi

    echo "Execute migrations for database '$entityManager':"
		dir=$(echo $entityManager | awk '{print toupper(substr($0,1,1)) tolower(substr($0,2))}')
    if [ "$( find ./src/$dir/Infrastructure/Persistence/Migrations -iname '*.php' -print -quit )" ]; then
    	php bin/console doctrine:migration:migrate --no-interaction --em=$entityManager --all-or-nothing
    fi
}

if [ "$1" = 'frankenphp' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then

	if [ -z "$(ls -A 'vendor/' 2>/dev/null)" ]; then
		composer install --prefer-dist --no-progress --no-interaction
	fi


	PREFIX="DATABASE_URL_"
	grep "^$PREFIX" .env | while IFS='=' read -r key value; do
  		suffix="${key#$PREFIX}"
  		suffix_lowercase=$(echo "$suffix" | tr '[:upper:]' '[:lower:]')

  		update_database $suffix_lowercase
	done


	setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
	setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var
fi

exec docker-php-entrypoint "$@"
