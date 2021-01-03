<?php


namespace core\base\controllers;

use core\base\exception\RouteException;
use core\base\settings\Settings;
use core\base\settings\ShopSettings;

class RouteController
{

    private static $instance;

    protected $routes;

    protected $controller;

    protected $inputMethod;

    protected $outputMethod;

    protected $params;

    /**
     * @return RouteController
     */
    public static function getInstance(): RouteController
    {
        if (self::$instance instanceof self){

            return self::$instance;
        }

        return self::$instance = new self;
    }

    private function createRoute($route, $url)
    {

    }

    private function __construct()
    {
        $address = $_SERVER['REQUEST_URI'];

        if (strpos($address, '/') === strlen($address) - 1 && strpos($address, '/') !== 0) {
            $this->redirect(rtrim($address, '/'), 301);
        }

        $path = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));

        if ($path !== PATH) {
            try {
                throw new \Exceptio('Not found path.');
            } catch (\Exception $e) {
                exit($e->getMessage());
            }
        } else {
            $this->routes = Settings::get('routes');
            if ($this->routes === null || $this->routes === '') {
                throw new RouteException('Not found routes.');
                exit();
            }

            if (strpos($address, $this->routes['admin']['name']) === strlen(PATH)) {

            } else {
                $url = explode('/', substr($address, strlen(PATH)));
                $hrUrl = $this->routes['user']['hrUrl'];
                $this->controller = $this->routes['user']['path'];
                $route = 'user';
                $this->creatwRoute($route, $url);
            }


        }
    }

    private function __clone()
    {

    }
}