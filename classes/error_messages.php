<?php

    class ErrorMessages
    {

        const ERROR_ADMIN_NEWCATEGORY_EXIST = "15c03fe765a67e5107690182150b1c3d";

        private $errorList = [];

        public function __construct()
        {
            $this->errorList = [
                ErrorMessages::ERROR_ADMIN_NEWCATEGORY_EXIST => 'error_newcategory'
            ];
        }

        public function get($hash)
        {
            return $this->errorList[$hash];
        }

        public function existsKey($key)
        {
            if(array_key_exists($key, $this->errorList))
            {
                return true;
            }
            return false;
        }
    }

?>