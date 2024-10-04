<?php

namespace App\routes;

class Request{

    public function url(){
     
        $path = $_SERVER['REQUEST_URI'] ?: '/';
        return str_contains($path,'?') ?explode('?',$path)[0] : $path; 
    }


    public function method(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }



}




?>