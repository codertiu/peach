<?php
namespace application\controllers;

use application\core\Controller;
use application\lib\DB;

/**
 * Class MainController
 * @package application\controllers
 */
class MainController extends Controller
{
    public function indexAction() {
        $vars = [
          'name' => 'Morgan',
          'year' => 2022
        ];

        $db = new DB;
        $params = [
            'id' => 1,
        ];
        //$data = $db->rows('SELECT * FROM users WHERE id = :id', $params);
        //$data = $db->column('SELECT name FROM users WHERE id = :id', $params);
        //debug($data);
        $this->view->render('Bosh sahifa', $vars);
    }
}

