<?php

    class UserModel extends Model implements IModel
    {
        private $id;
        private $username;
        private $password;

        public function __construct()
        {
            parent::__construct();
            $this->id       = 0;
            $this->user     = '';
            $this->password = '';
        }

        public function setId($id){$this->id = $id;}
        public function setUser($user){$this->user = $user;}
        public function setPassword($password){$this->password = $this->getHashedPassword($password);}

        public function getId(){return $this->id;}
        public function getUser(){return $this->user;}
        public function getPassword(){return $this->password;}

        public function save()
        {
            try
            {
                $query = $this->prepare('INSERT INTO USER(USER.NAME, USER.PASSWORD) VALUES (?,?)');
                $query->bindParam(1, $this->getUser());
                $query->bindParam(2, $this->getPassword());
                $query->execute();
                return true;
            }
            catch(PDOException $e)
            {
                error_log('UserModel::save-> PDOException: '.$e);
                return false;
            }
        }

        public function getAll()
        {
            $data = [];
            try
            {
                $query = $this->query('SELECT * FROM USER');
                while($row = $query->fetch(PDO::FETCH_ASSOC))
                {
                    $user  = new UserModel();
                    $user->setId($row['ID']);
                    $user->setUser($row['NAME']);
                    $user->setPassword($row['PASSWORD']);

                    array_push($data, $user);
                }
                return $data;
            }
            catch(PDOException $e)
            {
                error_log('UserModel::getAll-> PDOException: '.$e);
                return false;
            }
        }

        private function getHashedPassword($password)
        {
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
        } 

        public function get($id)
        {
            try
            {
                $query = $this->query('SELECT * FROM USER WHERE USER.ID = ?');
                $query->bindParam(1, $id);
                $query->execute();

                $user = $query->fetch(PDO::FETCH_ASSOC);
                $this->setId($user['ID']);
                $this->setUser($user['NAME']);
                $this->setPassword($user['PASSWORD']);
                
                return $this;
            }
            catch(PDOException $e)
            {
                error_log('UserModel::getAll-> PDOException: '.$e);
                return false;
            }
        }

        public function delete($id)
        {
            try
            {
                $query = $this->prepare('DELETE FROM USER WHERE USER.ID = ?');
                $query->bindParam(1, $id);
                $query->execute();
                return true;
            }
            catch(PDOException $e)
            {
                error_log('UserModel::delete-> PDOException: '.$e);
                return false;
            }
        }

        public function update(){}
        public function from($array){}
    }

?>