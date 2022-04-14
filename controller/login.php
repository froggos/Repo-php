<?php

    class Login extends Controller
    {
        function __construct()
        {
            parent::__construct();
            error_log('Login::construct-> Inicio de login.');
        }

        function render()
        {
            error_log('Login::render-> Carga de index de login.');
            $this->view->render('login/index');
        }
    }

?>