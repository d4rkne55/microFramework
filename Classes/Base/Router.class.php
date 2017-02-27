<?php

class Router
{
    const PROJECT_PATH = '/microFramework/';

    /**
     * This associative array consists of paths, which are regular expressions,
     * and of the corresponding methods to be called when the path matches.
     * Paths are handled case-insensitive
     *
     * Static methods need to be in the form 'Class::staticMethod' and methods needing the class to be instantiated
     * need to be an array in the following form: array('Class', 'method')
     *
     * @var array $routes
     */
    protected $routes = array(
        '' => array('Example', 'showWelcomePage'),
        '(\w+)' => array('Example', 'showWithInfo'),
        '(\w+)/(\d+)' => array('Example', 'showWithInfo')
    );

    /**
     * This variable defines the names/index of the parameters to be passed to the method,
     * so you can call $query['id'] in the method to get the first parameter match, the id, more meaningful than $query[0]
     *
     * @var array $paramNames
     */
    private $paramNames = array(
        'category',
        'id'
    );


    public function __construct() {
        $relativeUrl = $_SERVER['REQUEST_URI'];
        $request = new Request($relativeUrl);

        $path = $request->get('path');
        $relativePath = str_replace(self::PROJECT_PATH, '', $path);

        foreach ($this->routes as $route => $fnc) {
            $route = str_replace('/', '\/', $route);
            if (preg_match('/^' . $route . '\/?$/i', $relativePath, $matches)) {
                // remove full match from matches, not needed
                array_shift($matches);

                // give matches/parameters a named index from paramNames
                $params = array();
                foreach ($this->paramNames as $i => $name) {
                    $params[$name] = isset($matches[$i]) ? $matches[$i] : '';
                }
                // add POST data to the params array, if POST request
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    foreach ($_POST as $var => $value) {
                        $params[$var] = $value;
                    }
                }

                // for non-static methods, create a class instance first
                if (is_array($fnc)) {
                    $class = new $fnc[0]();
                    $fnc = array($class, $fnc[1]);
                }

                // instantiate the View class, to be able using it without instantiating it manually in every method
                $view = new View();

                call_user_func($fnc, $view, $params);
                break;
            }
        }
    }
}