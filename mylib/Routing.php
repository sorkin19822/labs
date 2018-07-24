<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 24.07.2018
 * Time: 11:54
 */
namespace mylib;

class Routing
{
    private $route;

    public function getRoute() {
        $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->route = explode('/', rtrim($_SERVER['REQUEST_URI_PATH'], '/'));

        return $this->route;
    }

}