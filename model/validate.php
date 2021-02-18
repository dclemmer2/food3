<?php
/* model/validate.php
 * Contains validation functions for Food app
 *
 */

class Validate
{
    private $_dataLayer;

    function __construct()
    {
        $this->_dataLayer = new DataLayer();
    }
    /** validFood() returns true if food is not empty and
     * contains only letters
     * @param String $food
     * @return boolean
     */
    function validFood($food)
    {
        //$validFoods = array("tacos", "eggs", "pizza");
        //&& inarray(strtolower($food), $validFoods);

        return !empty(trim($food)) && ctype_alpha($food);
    }

    /** validMeal() returns true if the selected meal is in the list
     * of valid options
     * @param String $meal
     * @return boolean
     */
    function validMeal($meal)
    {
        $validMeals = $this->_dataLayer->getMeals();
        return in_array($meal, $validMeals);
    }

    /** validCondiments() returns true if all of the condiments are
     * in the list of valid options
     * @param Array $selectedConds
     * @return boolean
     */
function validCondiments($selectedConds)
    {
        //Get valid condiments from data layer
        $validConds = $this->dataLayer->getCondiments();

        //Check every selected condiment
        foreach ($selectedConds as $selected) {

            //If the selected condiment is not in the valid list, return false
            if (!in_array($selected, $validConds)) {
                return false;
            }
        }
        //If we haven't false by now, we're good!
        return true;
    }
}