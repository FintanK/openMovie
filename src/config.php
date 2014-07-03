<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "../vendor/autoload.php";
require "../lib/html_tag_helpers.php";
require "../lib/AbstractSPARQLEndpoint.php";
require "../lib/DBPedia.php";
require "../lib/IMDB.php";

$container = new Pimple();
$container['DBPedia'] = new DBPedia();
$container['IMDB'] = new IMDB();

