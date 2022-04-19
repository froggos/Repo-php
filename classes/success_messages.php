<?php

    class SuccessMessages
    {
        const SUCCESS_ADMIN_NEWCATEGORY_EXIST = "d65710b51d017444046accc151ff6c68";

        private $successList = [];

        public function __construct()
        {
            $this->successList = [
                SuccessMessages::SUCCESS_ADMIN_NEWCATEGORY_EXIST => 'success_newcategory'
            ];
        }

        public function get($hash)
        {
            return $this->successList[$hash];
        }

        public function existsKey($key)
        {
            if(array_key_exists($key, $this->successList))
            {
                return true;
            }
            return false;
        }
    }

?>