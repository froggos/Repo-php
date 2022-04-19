<?php

    class Controller
    {
        public function __construct()
        {
            $this->view = new View();
        }

        function loadModel($model)
        {
            $url = 'model/'.$model.'model.php';
            if(file_exists($url))
            {
                require_once $url;
                $modelName = $model.'Model';
                $this->model = new $modelName();
            }
        }

        function existPOST($params)
        {
            foreach($params as $param)
            {
                if(!isset($_POST[$param]))
                {
                    error_log('Controller::existPOST-> No existe el parámetro'.$param);
                    return false;
                }
            }
            return true;
        }

        function existGET($params)
        {
            foreach($params as $param)
            {
                if(!isset($_GET[$param]))
                {
                    error_log('Controller::existGET-> No existe el parámetro'.$param);
                    return false;
                }
            }
            return true;
        }

        function getPOST($name)
        {
            return $_POST[$name];
        }

        function getGET($name)
        {
            return $_GET[$name];
        }

        function redirect($route, $messages)
        {
            $data = [];
            $params = '';

            foreach($messages as $key => $message)
            {
                array_push($data, $key.'='.$message);
            }
            $params = join('&', $data);

            if($params != '')
            {
                $params = '?'.$params;
            }

            header('Location: '.constant('URL').$route.$params);
        }
    }

?>