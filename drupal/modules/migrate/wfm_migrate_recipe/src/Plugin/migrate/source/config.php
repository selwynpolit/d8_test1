<?php

require('../vendor/autoload.php');

//define('API_SECRET', 'OdbxrTDUfqHbeADt');
//define('API_KEY', 'a4tO6ASB7crAQtPcDIhVE1O0nPUkMLRk');
//define('API_URL', 'https://api.wholefoodsmarket.com:1600');

define('API_SECRET', 'V6HCtydR4lZPXU1w');
define('API_KEY', '5Ecv3p8SSYJvQ4rvG0rv6h2XRRClf86o');
define('API_URL', 'https://api.wholefoodsmarket.com:1700');

/**
 * Pretty print a data object
 * @param mixed $pre object or array to print
 * @param string $name An optional heading to put on top of the output
 * @return void
 */
function pre($pre, $name = null)
{
    if ($name) {
        echo '<h3>' . $name . '</h3>';
    }

    echo '<pre>';
    print_r($pre);
    echo '</pre>';
}

// Catch all exceptions here. Do not use this in production or include this in your code
set_exception_handler(function (\Exception $e) {
    echo '<h3 style="color:darkred;">' . $e->getMessage() . '</h3>';
    echo '<pre>';
    print_r($e->getTraceAsString());
    echo '</pre>';
});