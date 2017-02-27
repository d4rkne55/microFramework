<?php
// this variable defines the folders which contain Class files, relative to this file
$classDirs = array(
    'Classes/Base',
    'Classes'
);

/**
 * This is the autoloader, that automatically includes the files for needed Classes
 */
spl_autoload_register(function($class) use ($classDirs) {
    foreach ($classDirs as $dir) {
        $path = "$dir/$class.class.php";
        if (file_exists($path)) {
            require $path;
            break;
        }
        // just for semantics, not needed
        else continue;
    }
});


/**
 * Instantiate the Router
 * there the routing takes place, which automatically calls the method belonging to the requested URL
 */
new Router();