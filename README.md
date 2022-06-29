# 2ehands backend

This is the backend for the 2ehands website. It is written in PHP using [Laravel](https://laravel.com/).

### Installation

To get started running this project you will need to need the following:
- [Docker](https://www.docker.com/)
- [Docker-Compose](https://docs.docker.com/compose/install/)

Please note that on Windows you will need to install this on WSL.

The first thing you will need to do now is to install the dependencies.
You can do this by running the following command:
```
docker run --rm -u $(id -u):$(id -g) -v $(pwd):/opt -w /opt laravelsail/php81-composer:latest composer install --ignore-platform-reqs 
```
Once that has been done you can run the following command to start the backend.
Next up you will need to copy the `.env.example` to `.env`. 
Most things can be left as they are. If you get an error about the `ID` or `GID` being incorrect, please see troubleshooting.

Now it is possible to start the backend:
```
./vendor/bin/sail up
```

The next step is to migrate (initalize) the database. This can be done by running the following command:
```
./vendor/bin/sail artisan migrate --seed
```

Your project should now be available on http://localhost.

### Troubleshooting

#### GID and UID
In the `.env` file set the following to your user ID and group ID. You can retrieve those by running the `id` command.
```dotenv
WWWGROUP=1000
WWWUSER=1000
```
