<?php 
    // ob_start();

    defined('DS')             ? null : define('DS', DIRECTORY_SEPARATOR);
    defined('SITE_ROOT')      ? null : define('SITE_ROOT', dirname(dirname(dirname(__FILE__))));
    defined('INCLUDES_PATH')  ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');


    // echo define('BASE', dirname(dirname(dirname(__FILE__))));
    // echo dirname(dirname(dirname(__FILE__)));

    require_once("functions.php");
    require_once("config.php");
    require_once("database.php");
    require_once("db_object.php");
    require_once("user.php");
    require_once("photo.php");
    require_once("session.php");
    require_once("comment.php");
    require_once("paginate.php");

?>