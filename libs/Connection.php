<?php

    require_once 'config/Database.php';

    class Connection
    {
        private $connection = null;

        public function Connect()
        {
            try
            {
                $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $this->connection->set_charset('utf-8');
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
            }
            return $this->connection;
        }

        public function Disconnect()
        {
            if($this->connection != null)
            {
                mysqli_close($this->connection);
            }
            return $this->connection;
        }
    }

?>