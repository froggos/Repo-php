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
    }

?>