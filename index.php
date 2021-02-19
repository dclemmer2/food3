<?php
//This is my CONTROLLER

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require files
require_once('vendor/autoload.php');
//require_once('model/data-layer.php');
//require_once('model/validate.php');

//Start a session
session_start();

//Create an instance of the Base class
$f3 = Base::instance();

//add classes
$validator = new Validate();
$dataLayer = new DataLayer();
$order = new Order();
$controller = new Controller($f3);

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route (home page)
$f3->route('GET /', function () {
    global $controller;
    $controller->home();
});

//Define a "order" route
$f3->route('GET|POST /order', function ($f3) {
    global $controller;
    $controller->order();
});

//Define a "order2" route
$f3->route('GET|POST /order2', function ($f3) {
    global $controller;
    $controller->order2();
});

//Define a "summary" route
$f3->route('GET /summary', function () {
    global $controller;
    $controller->summary();
});

//Run fat free
$f3->run();