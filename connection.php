<?php
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\ServerApi;

$client = new MongoDB\Client(
   'mongodb://localhost:27017'
);
$db = $client->user_db;