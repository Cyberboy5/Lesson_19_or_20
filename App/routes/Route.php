<?php

namespace App\Routes;

class Route {

    public static $routes = [];
    public $request;

    // Corrected constructor: assign $request to $this->request
    public function __construct(Request $request) {
        $this->request = $request;  // Fixed assignment
    }

    // Add a POST route
    public static function post($url, $action) {
        self::$routes['post'][$url] = $action;  // Fixed $url key without quotes
    }

    // Add a GET route
    public static function get($url, $action) {
        self::$routes['get'][$url] = $action;  // Fixed $url key without quotes
    }

    // Process the action based on the request
    public function action() {
        $path = $this->request->url();  // Get the URL path from the request
        $method = $this->request->method();  // Get the HTTP method

        // Get the action from the routes based on the method and path
        $action = self::$routes[$method][$path] ?? false;

        if (!$action) {
            echo '404 Page not found: ' . $path;
            return;
        }

        // If action is callable, invoke it
        if (is_array($action)) {
            call_user_func_array([new $action[0],$action[1]],[]);
        }
    }
}

?>
