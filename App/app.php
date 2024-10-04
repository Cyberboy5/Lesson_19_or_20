<?php
namespace app;


use App\routes\Request;
use App\routes\Route;


class App{


    public function run(){

        $request = new Request();
        $route = new Route($request);

        $action = $route->action();
        return $action;

    }
}

?>