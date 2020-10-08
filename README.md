# Laravel ChangeLog
Add changelogs to your laravel project

This allow you to add changelogs to your laravel app, it will create a json file for each release and then merge them as one json object or show them as html file.
The package provide also a simple form to create new log.

## List

![the list of the logs](list.png)

## Form

![the form of the logs](form.png)


## Installation

You can install this package via composer using this command:

`composer require mohkoma/change-log`

## Usage

The package will automatically register itself.
You can publish the config-file and the views with:
`php artisan vendor:publish --provider="Mohkoma\ChangeLog\ChangeLogServiceProvider"`

You can publish the config-file and the views with:
`php artisan vendor:publish --provider="Mohkoma\ChangeLog\ChangeLogServiceProvider"`

## Routes

`/dev/changelog/create/` for showing the form.
`/dev/changelog` for showing the list of the logs.
`/dev/changelog/json` show logs as a json object

## Configuration

```php
<?php 

return [

    // Classify your changelogs by release date, start with oldest.
    'versions' => [
        '1.0.0' => '2020-10-01',
        '1.0.2' => '2020-10-06',
    ],

    // The name of your storage disk - better to be in the root of your project.
    'storage_disk' => 'changelog',

    // The folder name where your json files will be located.
    'directory_name'  => 'changelog',

    // The middleware of the routes
    'middleware' => [
        'read'  => ['web', 'auth', 'developer'],
        'write' => ['developer']
    ]
];
```