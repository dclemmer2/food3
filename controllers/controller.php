<?php

//  controllers/controller.php

class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    /** Display home page */
    function home()
    {
        //Display a view
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /** Display order1 page */
    function order()
    {
        //var_dump($_POST);
        global $validator;
        global $dataLayer;
        global $order;

        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            //Get the data from the POST array
            $userFood = trim($_POST['food']);
            $userMeal = $_POST['meal'];

            //If the data is valid --> Store in session
            if($validator->validFood($userFood)) {
                $order->setFood($userFood);
            }
            //Data is not valid -> Set an error in F3 hive
            else {
                $this->_f3->set('errors["food"]', "Food cannot be blank and must contain only characters");
            }

            if($validator->validMeal($userMeal)) {
                $order->setMeal($userMeal);
            }
            else {
                $this->_f3->set('errors["meal"]', "Select a meal");
            }

            //If there are no errors, redirect to /order2
            if(empty($this->_f3->get('errors'))) {
                $_SESSION['order'] = $order;
                $this->_f3->reroute('/order2');  //GET
            }
        }

        //var_dump($_POST);
        $this->_f3->set('meals', $dataLayer->getMeals());
        $this->_f3->set('userFood', isset($userFood) ? $userFood : "");
        $this->_f3->set('userMeal', isset($userMeal) ? $userMeal : "");

        //Display a view
        $view = new Template();
        echo $view->render('views/form1.html');
    }

    function order2()
    {
        global $validator;
        global $dataLayer;

        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            //If condiments were selected
            if(isset($_POST['conds'])) {

                //Get condiments from post array
                $userCondiments = $_POST['conds'];

                //Data is valid -> Add to session
                if ($validator->validCondiments($userCondiments)) {
                    $condimentString = implode(", ", $userCondiments);
                    $_SESSION['order']->setCondiments($condimentString);
                }
                //Data is not valid -> We've been spoofed!
                else {
                    $this->_f3->set('errors["conds"]', "Go away, evildoer!");
                }
            }

            //If there are no errors, redirect user to summary page
            if (empty($this->_f3->get('errors'))) {
                $this->_f3->reroute('/summary');
            }
        }

        $this->_f3->set('condiments', $dataLayer->getCondiments());

        //Display a view
        $view = new Template();
        echo $view->render('views/form2.html');
    }

    function summary()
    {

        //echo "<p>POST:</p>";
        //var_dump($_POST);

        //echo "<p>SESSION:</p>";
        //var_dump($_SESSION);

        //Display a view
        $view = new Template();
        echo $view->render('views/summary.html');

        //Write to database

        //Clear the SESSION array
        session_destroy();
    }
}
