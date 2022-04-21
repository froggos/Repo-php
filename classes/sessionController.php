<?php

    require_once 'classes/session.php';

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

        /**
         * init()
         * 
         * Invocamos un objeto de tipo sesión para poder usar sus métodos y poder hacer las validaciones respectivas.
         * 
         * La variable $session toma un nuevo objeto de tipo Session.
         * Se obtienen todas las páginas del JSON y se dividen en $sites y $defaultSites.
         * Se invoca a validateSession().
         */
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

        /**
         * validateSession()
         * 
         * Validamos el tipo de sesión que presenta el cliente, y lo redireccionamos a sus 
         */
        public function validateSession()
        {
            error_log('SessionController::validateSession');
            if($this->existsSession())
            {
                $role = $this->getUserSessionData()->getRole();
                if($this->isPublic())
                {
                    $this->redirectDefaultSiteByRole($role);
                }
                else
                {
                    if($this->isAuthorized($role))
                    {

                    }
                    else
                    {
                        $this->redirectDefaultSiteByRole($role);
                    }
                }
            }
            else
            {
                if($this->isPublic())
                {

                }
                else
                {
                    header('Location: '.constant('URL').'');
                }
            }
        }

        /**
         * existsSession()
         * 
         * Nos permite saber si es que hay una sesión creada. Con esto podemos redireccionar a nuestro cliente hacia las respectivas páginas.
         * 
         * Preguntamos si es que existe sesión con el método de la clase Session exists(). Retorna booleano.
         * Comparamos al usuario actual para verificar que no sea null. Retorna booleano.
         * Almacenamos la el tipo de usuario en $userId.
         * Verificamos que $userId exista. Retorna booleano.
         */
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

            $this->userId = $this->session->getCurrentUser();
            
            if($this->userId) 
            {
                return true;
            }

            return false;
        }

        /**
         * getUserSessionData()
         * 
         * Nos retorna un objeto de tipo UserModel con el fin de usar sus métodos y obtener sus datos. Para ello obtenemos el Id de la sesión actual y
         * usamos el método get de UserModel para poder obtener todos sus datos. Retornamos el objeto UserModel.
         * 
         * Se almacena el valor de $userId en $id.
         * Se crea el objeto de tipo UserModel en $user.
         * Se ejecuta el método get con la variable $id.
         * Se retorna el objeto $user.
         */
        function getUserSessionData()
        {
            $id = $this->userId;
            $this->user = new UserModel();
            $this->user->get($id);
            error_log('SessionController::getUserSessionData-> '.$this->user->getUser());
            return $this->user;
        }

        /**
         * isPublic()
         * 
         * Obtenemos mediante el método getCurrentPAge() la página actual sobre la que se encuentra el cliente. Se reemplazan los carácteres
         * con una expresión regular con tal de solo obtener el nombre de la página, luego se compara este nombre con nuestro arreglo de sitios.
         * Si es que nuestra url es igual a algún valor de nuestro arreglo de sitios, y si es este sitio está configurado como público retornamos true.
         * En caso contrario retornamos false.
         * 
         * Almacenamos en la variable $currentURL el valor que nos devuelve getCurrentPage().
         * Sobre $currentURL aplicamos un filtro de carácteres mediante el método preg_replace().
         * Iteramos por cada uno de los valores almacenados en $sites.
         * Comparamos el valor de $currentURL (con el filtro aplicado) los valores en $sites, además verificamos que el valor 'access' de $sites sea 'public'.
         * En caso de que esté todo correcto, retorna true.
         * En caso contrario retorna false.
         */
        function isPublic()
        {
            $currentURL = $this->getCurrentPage();
            $currentURL = preg_replace("/\?.*/", "", $currentURL);
            for($i = 0; $i < sizeof($this->sites); $i++)
            {
                if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['access'] == 'public')
                {
                    return true;
                }
            }
            return false;
        }

        /**
         * getCurrentPage()
         * 
         * Obtenemos la dirección actual sobre la que se encuentra el cliente. Separamos la cadena obtenida por el carácter '/' y 
         * devolvemos el segundo valor del array de cadenas.
         * 
         * La variable $actualLink recibe el URL actual junto con el método trim() para quitar los espacios en blanco.
         * Se utiliza el método explode() para separar el valor de $actualLink por cada carácter '/'. El resultado se almacena en $url.
         * Retornamos el tercer elemento almacenado en $url.
         */
        function getCurrentPage()
        {
            $actualLink = trim("$_SERVER[REQUEST_URI]");
            $url = explode('/', $actualLink);
            error_log('SessionController::getCurrentPage-> '.$url[2]);
            return $url[2];
        }


        /**
         * redirectDefaultSiteByRole($param)
         * 
         * Usamos el valor del rol de nuestra sesión para redirigir al sitio por defecto determinado para el tipo de rol.
         * 
         * Recibimos un parámetro para nuestro método.
         * Declaramos la variable $url vacía.
         * Iteramos por cada uno de los valores almacenados en $sites.
         * Comparamos cada elemento de $sites con la clave de 'role' con el parámetro dado al método.
         * Si coincide con algún valor, obtenemos de $sites el valor de la posición de $i con la clave 'site' y le asignamos el resultado a $url. 
         * A nuestra primera coincidencia, escapamos del ciclo for.
         * Usamos el valor de $url para redirigir al cliente mediante header().
         */
        private function redirectDefaultSiteByRole($role)
        {
            $url = '';
            for($i = 0; $i < sizeof($this->sites); $i++)
            {
                if($this->sites[$i]['role'] == $role)
                {
                    $url = $this->sites[$i]['site'];
                    break;
                }
            }
            header('Location: '.$url);
        }

        private function isAuthorized($role)
        {
            $currentURL = $this->getCurrentPage();
            $currentURL = preg_replace("/\?.*/", "", $currentURL);
            for($i = 0; $i < sizeof($this->sites); $i++)
            {
                if($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['role'] == $role)
                {
                    return true;
                }
            }
            return false;
        }

        function initialize($user)
        {
            $this->session->setCurrentUser($user->getId());
            $this->authorizeAccess($user->getRole());
        }

        function authorizeAccess($role)
        {
            switch($role)
            {
                case 'admin':
                    $this->redirect($this->defaultSites['admin'], []);
                    break;
            }
        }

        function logout()
        {
            $this->session->closeSession();
        }
    }

?>