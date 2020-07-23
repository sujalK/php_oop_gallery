<?php 

    // function __autoload($class) {

    //     $class= strtolower($class);
        
    //     $the_path= "includes/{$class}.php";

    //     if(file_exists($the_path)) {
    //         include_once($the_path);
    //     } else {
    //         die("This file name {$class} .php was not found.");
    //     }

    // }

    spl_autoload_register(function($class) {

        $class= strtolower($class);

        $the_path= "includes/{$class}.php";

        if(file_exists($the_path)) {
            include_once($the_path);
        } else {
            die("This file name {$class} .php was not found.");
        }

    });


    function redirect($location) {
        header("Location: {$location}");
    }


?>