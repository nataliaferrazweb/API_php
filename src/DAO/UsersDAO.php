<?php

namespace App\DAO;

use App\Models\UserModel;

class UsersDAO extends Conection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertUser(UserModel $user): void
    {
        try {
            $statement = $this->pdo
                ->prepare('INSERT INTO users
                (
                    name,
                    email,
                    password
                )
                VALUES
                (
                    :name,
                    :email,
                    :password
                );
            ');
            $statement->execute([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => password_hash($user->getPassword(), PASSWORD_ARGON2I)
            ]);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getUserByEmail(string $email): ?UserModel
    {
        try {
            $statement = $this->pdo
                ->prepare('SELECT
                    id,
                    name,
                    email,
                    password
                FROM users
                WHERE email = :email;
            ');
            $statement->bindParam('email', $email);
            $statement->execute();
            $users = $statement->fetchAll(\PDO::FETCH_ASSOC);
            if (count($users) === 0)
                return null;
            $user = new UserModel();
            $user->setId($users[0]['id'])
                ->setName($users[0]['name'])
                ->setEmail($users[0]['email'])
                ->setPassword($users[0]['password']);
            return $user;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }


}
