<?php

    require_once 'controller/error.php';

    class App
    {
        function __construct()
        {
            $url = isset($_GET['url']) ? $_GET['url'] : null;
            $url = rtrim($url, '/');
            $url = explode('/', $url);

            if(empty($url[0]))
            {
                error_log('App::contruct-> No existe un controlador especificado');
                $loginController = 'controller/login.php';
                require_once $loginController;
                $controller = new Login();
                $controller->loadModel('login');
                $controller->render();
                return false;
            }
            $Controller = 'controller/'.$url[0].'php';

            if(file_exists($Controller))
            {
                require_once $Controller;
                $controller = new $url[0];
                $controller->loadModel($url[0]);
                if(isset($url[1]))
                {
                    if(method_exists($controller, $url[1]))
                    {
                        if(isset($url[2]))
                        {
                            $nparam = count($url) - 2;
                            $params = [];
                            for($i = 0; $i < $nparam; $i++)
                            {
                                array_push($params, $url[$i] + 2);
                            }
                            $controller->{
                                $url[1]
                            }($params);
                        }
                        else
                        {
                            $controller->{
                                $url[1]
                            }();
                        }
                    }
                    else
                    {
                        $controller = new Errors();
                        $controller->render();
                    }
                }
                else
                {
                    $controller->render();
                }
            }
            else
            {
                $controller = new Errors();
                $controller->render();
            }
        }
    }

?>