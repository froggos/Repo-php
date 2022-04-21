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

        /**
         * 
         * Recibe como parámetro un array.
         * Recorre el array y convierte sus elementos a $param.
         * Si el array no contiene ningún valor para POST entonces retorna falso.
         * En caso contrario retorna verdadero.
         */
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

        /**
         * Recibe dos parámetros, $route como la ruta a redireccionar y $messages como un array que contienen cada uno de los parámetros de GET.
         * Se declara la variable $data como array, y la variable $params como string.
         * Se recorre cada uno de los parámetros almacenados en $messages, separando sus claves($key) y valores($message).
         * Se crea una cadena(string) usando la siguiente estructura: llave=valor, usando $key y $message. Esto se almacena $data.
         * Ahora bien, después de todo esto, si la variable $params no está vacía, se le concatena al principio un ?.
         * Se usa $route recibido por el método y se concatena con la variable $params dando como resultado, por ejemplo,
         * la siguiente estructura: http://localhost/Control-Stock-TS/ruta?llave=valor. 
         */
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