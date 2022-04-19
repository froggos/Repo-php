<?php

    include_once 'libs/IModel.php';

    class Model
    {
        function __construct()
        {
            $this->db = new Connection();
        }

        function query($query)
        {
            return $this->db->Connect()->query($query);
        }

        function prepare($query)
        {
            return $this->db->Connect()->prepare($query);
        }
    }

?>