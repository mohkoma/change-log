<?php 

return [

    // Classify your changelogs by release date, start with oldest.
    'versions' => [
        '1.0.0' => '2020-10-01'
    ],

    // The name of your storage disk - better to be in the root of your project.
    'storage_disk' => 'public',

    // The folder name where your json files will be located.
    'directory_name'  => 'changelog',

    // The middleware of the routes
    'middleware' => [
        'read'  => ['web'],
        'write' => []
    ]
];