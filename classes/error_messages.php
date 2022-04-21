<?php

    class ErrorMessages
    {

        const ERROR_ADMIN_NEWCATEGORY_EXIST = "15c03fe765a67e5107690182150b1c3d";
        const ERROR_LOGIN_AUTHENTICATE_EMPTY = "f3fde234488a3adb596a4b9817a3fb60";
        const ERROR_LOGIN_AUTHENTICATE = "6365a5388b26d1e0732db0284c5f1ea2";
        const ERROR_LOGIN_DATA = "4ef60e0b2d163159c40ef3a4ab6dc515";

        private $errorList = [];

        public function __construct()
        {
            $this->errorList = [
                ErrorMessages::ERROR_ADMIN_NEWCATEGORY_EXIST => 'error_newcategory',
                ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY => 'error_login_authenticate_empty',
                ErrorMessages::ERROR_LOGIN_AUTHENTICATE => 'error_login_authenticate',
                ErrorMessages::ERROR_LOGIN_DATA => 'error_login_data',
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