<?php

    class SessionController extends Controller
    {
        private $userSession;
        private $userName;
        private $userId;

        private $session;
        private $sites;

        private $user;

        public function __construct()
        {
            parent::__construct();
            $this->init();
        }

        function init()
        {
            $this->session = new Session();
            $json = $this->getJSONFileConfig();

            $this->sites = $json['sites'];
            $this->defaultSites = $json['default-sites'];

            $this->validateSession();
        }

        private function getJSONFileConfig()
        {
            $string = file_get_contents('config/access.json');
            $json = json_decode($string, true);
            return $json;
        }

        public function validateSession()
        {
            error_log('SessionController::validateSession');
            if($this->existsSession())
            {

            }
            else
            {

            }
        }

        public function existsSession()
        {
            if(!$this->session->exists())
            {
                return false;
            }
            
            if($this->session->getCurrentUser() == null)
            {
                return false;
            }

            $userid = $this->session->getCurrentUser();
        }
    }

?>