<?php

namespace App\Controllers;


class Controllers{

    public function index(){
        include realpath(__DIR__ . "/../views/products/index.php");
    }

    public function test(){
        include realpath(__DIR__ . "/../views/test/index.php");
    }


}



?>