<?php
/* model/validate.php
 * Contains validation functions for Food app
 *
 */

/** validFood() returns true if food is not empty and contains only letters */
function validFood($food)
{
    //$validFoods = array("tacos", "eggs", "pizza");
    // && in_array(strtolower($food), $validFoods);

    return !empty($food) && ctype_alpha($food);
}

/** validMeal() returns true if the selected meal is in the list of valid options */
function validMeal($meal)
{
    $validMeals = getMeals();
    return in_array($meal, $validMeals);
}