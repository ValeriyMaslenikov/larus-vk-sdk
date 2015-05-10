<?php

require __DIR__ . '/../vendor/autoload.php';

use \LarusVK\Sections;

//$users_method = new Sections\Methods\Users\Get();
//
//$users_method->execute(
//    Sections\Methods\FieldCollection::fromArray(['user_ids' => 18177020]),
//    new GuzzleHttp\Client()
//);


/** @var \LarusVK\LarusClient $larus_client */
$larus_client = new \LarusVK\LarusClient();

$larus_client->users->get([
    'user_ids' => 18177020
]);

/*$larus_client->users->get([

]);*/