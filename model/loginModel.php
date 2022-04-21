<?php

    class LoginModel extends Model
    {
        function __construct()
        {
            parent::__construct();
        }

        function login($username, $password)
        {
            try
            {
                $query = $this->prepare('SELECT * FROM USER (USER.NAME, USER.PASSWORD) WHERE USER.NAME = ?');
                $query->bindParam(1, $username);
                $query->execute();

                if($query->rowCount() == 1)
                {
                    $item = $query->fetch(PDO::FETCH_ASSOC);
                    $user = new UserModel;
                    $user->from($item);

                    if(password_verify($password, $user->getPassword()))
                    {
                        error_log('LoginModel::login-> Éxito');
                        return $user;
                    }
                    else
                    {
                        error_log('LoginModel::login-> Contraseña incorrecta');
                        return NULL;
                    }
                }
            }
            catch(PDOException $e)
            {
                error_log('LoginModel::login-> '. $e->getMessage());
                return NULL;
            }
        }
    }

?>