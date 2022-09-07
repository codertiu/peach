<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller
{

    public function loginAction() {
        // $this->view->redirect('/');
        $this->view->render('Login');
    }
}