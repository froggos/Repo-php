<?php

    class View
    {
        function __construct()
        {
            
        }

        function render($name, $data = [])
        {
            $this->d = $data;
            require 'view/'.$name.'.php';
        }
    }

?>