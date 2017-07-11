<?php

class Router
{
    /** @var ConfigHelper $config */
    private $config = array();


    public function __construct() {
        $this->config = new ConfigHelper('config.yml');

        // get path relative to the project URL path
        $relativePath = str_replace(ROOT, '', $_SERVER['REQUEST_URI']);

        $routes = $this->config->get('routing:routes');

        if ($routes == null) {
            throw new Exception('Router: There are no routes defined in the config.yml!');
        }

        foreach ($routes as $route) {
            $routeRegex = $this->buildRegexForRoute($route['pattern']);

            if (preg_match("/$routeRegex/i", $relativePath, $matches)) {
                $callable = $route['handler'];

                // for non-static methods, create a class instance first
                if (is_array($callable)) {
                    $class = new $callable['class']();
                    $callable = array($class, $callable['method']);
                }

                $params = $this->buildParameters($matches);

                call_user_func($callable, $params);
                break;
            }
        }
    }

    /**
     * Takes the route from the config and builds a regex for the route
     *
     * @param string $route
     * @return string
     */
    private function buildRegexForRoute($route) {
        $varConditions = $this->config->get('routing:conditions');

        // replace variables with corresponding regex, including parentheses for matching
        $route = preg_replace_callback('/\(\$(\w+)\)/', function($matches) use ($varConditions) {
            $var = $matches[1];

            return '(' . $varConditions[$var] . ')';
        }, $route);

        // escape slashes
        $route = str_replace('/', '\/', $route);

        // allow trailing slash, whole string must match (^$)
        $route = '^' . $route . '\/?$';

        return $route;
    }

    /**
     * Returns an associative array with the matched route variables/conditions and POST values
     *
     * @param array $matches
     * @return array
     */
    private function buildParameters($matches) {
        // remove full match (first element) from matches, not needed
        array_shift($matches);

        $params = array();
        $conditions = $this->config->get('routing:conditions');
        $conditionNames = ($conditions) ? array_keys($conditions) : array();

        foreach ($conditionNames as $i => $name) {
            $params[$name] = isset($matches[$i]) ? $matches[$i] : '';
        }

        // add POST data to the params array, if POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST as $var => $value) {
                $params[$var] = $value;
            }
        }

        return $params;
    }
}