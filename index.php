<?php
//This is my CONTROLLER

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require files
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validate.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route (home page)
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define a "order" route
$f3->route('GET|POST /order', function ($f3) {
    //Add data from form1 to Session array
    //var_dump($_POST);

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Get the data from the POST array
        $userFood = trim($_POST['food']);
        $userMeal = $_POST['meal'];

        //if the data is valid -> add to session
        if (validFood($userFood)) {
            $_SESSION['food'] = $userFood;
        } //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["food"]', "Food cannot be blank and must 
            contain only characters");
        }

        //if the data is valid -> add to session
        if (validMeal($userMeal)) {
            $_SESSION['meal'] = $userMeal;
        } //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["meal"]', "Select a meal");
        }

        //if there are no errors, redirect to /order2
        if (empty($f3->get('errors'))) {
            $f3->reroute('/order2'); //GET
        }
    }

    $f3->set('meals', getMeals());
    $f3->set('userFood', isset($userFood) ? $userFood : "");
    $f3->set('userMeal', isset($userMeal) ? $userMeal : "");

    //Display a view
    $view = new Template();
    echo $view->render('views/form1.html');
});

//Define a "order2" route
$f3->route('GET|POST /order2', function ($f3) {

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //if condiments were selected
        if (isset($_POST['conds'])) {
            //Get condiments from post array
            $userCondiments = $_POST['conds'];

            //if the data is valid -> add to session
            if (validCondiments($userCondiments)) {
                $_SESSION['conds'] = implode(", ", $userCondiments);
            }

            //data is not valid -> spoofed
            else {
                $f3->set('errors["conds"]', "Go away");
            }
        }

        //If there are no errors, redirect user to summary page
        if (empty($f3->get('errors'))) {
            $f3->reroute('/summary');
        }
    }

    $f3->set('condiments', getCondiments());

    //Display a view
    $view = new Template();
    echo $view->render('views/form2.html');
});

//Define a "summary" route
$f3->route('GET /summary', function () {

    //Display a view
    $view = new Template();
    echo $view->render('views/summary.html');

    //CLear the SESSION array
    session_destroy();
});

//Run fat free
$f3->run();