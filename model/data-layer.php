<?php

/* model/data-layer.php
 * returns data for my app
 *
 */

class DataLayer
{
    /** getMeals() returns an array of meals
     *  @return array
     */
    function getMeals()
    {
        return array("breakfast", "lunch", "dinner");
    }

    /** getCondiments() returns an array of condiments
     *  @return array
     */
    function getCondiments()
    {
        return array("mayonnaise", "ketchup", "mustard", "sriracha");
    }
}