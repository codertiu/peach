<?php

namespace application\core;

use application\core\View;

/**
 * Class Controller
 * @package application\core
 * !!! bu controllerdan meros olinganda controllerning NomiController -> views/nomi papka bo'ladi
 * va indexAction metodidagi "index" -> nomi/index.php faylini ko'radi!
 */
abstract class Controller
{
    public $route;
    public $view;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
    }
}