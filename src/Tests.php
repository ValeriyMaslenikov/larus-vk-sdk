<?php

require __DIR__ . '/../vendor/autoload.php';

use \LarusVK\Sections;

$users_method = new Sections\Methods\Users\Get();

$users_method->execute(
    Sections\Methods\FieldCollection::fromArray(['user_ids' => 18177020]),
    new GuzzleHttp\Client()
);