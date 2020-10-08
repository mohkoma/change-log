<?php 

return [

    // Classify your changelogs by release date, start with oldest.
    'versions' => [
        '1.0.0' => '2020-10-01',
        '2.0.1' => '2020-10-05',
        '3.0.1' => '2020-10-10',
        '3.0.5' => '2021-12-10'
    ],

    // The name of your storage disk - better to be in the root of your project.
    'storage_disk' => 'changelog',

    // The folder name where your json files will be located.
    'directory_name'  => 'changelog',

    // The middleware of the routes
    'middleware' => [
        'read'  => ['auth', 'saka_admin'],
        'write' => ['auth', 'developer']
    ]
];