# Weather parser

[![license](https://img.shields.io/github/license/mashape/apistatus.svg?maxAge=2592000)](http://opensource.org/licenses/MIT)

## Requirements

- PHP >= 5.5.9
- [Composer](https://getcomposer.org/download/) - Package manager for PHP
- [NPM](https://npmjs.org/) - Node package manager
- [Gulp](https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md#getting-started)

## Installation

- clone repository
- run installer script via `./install` or `bash install`

> Installer script is a bash script that runs list of commands one-by-one. It is created to simplify installation process.

## Database

Set proper credentials in `.env` file in order to use database.

Run migrations via `php artisan migrate`.

## Parser

Run parser via `php artisan parse:forecast`

## License

The repository code is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
