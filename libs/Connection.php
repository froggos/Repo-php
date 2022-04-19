<?php

    class Connection
    {
        private $host;
        private $db;
        private $user;
        private $password;
        private $charset;

        public function __construct()
        {
            $this->host     = constant('DB_HOST');
            $this->db       = constant('DB_NAME');
            $this->user     = constant('DB_USER');
            $this->password = constant('DB_PASS');
            $this->charset  = constant('DB_CHAR');
        }

        function Connect()
        {
            try
            {
                $connection = 'mysqli:host='.$this->host.';dbname='.$this->db.';charset='.$this->charset;
                $options = [
                    PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES  => false,
                ];

                $pdo = new PDO($connection, $this->user, $this->password, $options);
                error_log('Conexión exitosa.');
                return $pdo;
            }
            catch(PDOException $e)
            {
                error_log('Error de conexión: '.$e->getMessage());
            }
        }
    }

?>