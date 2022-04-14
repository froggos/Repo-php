<?php

    class Error extends Controller
    {
        function __construct()
        {
            parent::__construct();
            error_log('Error::construct-> Invocación de errores.');            
        }

        function render()
        {
            $this->view->render('error/index');
        }
    }

?>