<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\DAO\UsersDAO;
use App\Models\UserModel;

class UserController extends ValidateController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
    }

    public function insertUsers(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();

            $usersDAO = new UsersDAO();
            $user = new UserModel();

            if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])
                || $this->validateVars($data['name']) || $this->validateVars($data['email']) || $this->validateVars($data['password'])) {
                $payload = json_encode([
                    'error' => \Exception::class,
                    'status' => 400,
                    'code' => '003',
                    'userMessage' => 'Invalid null argument.']);

                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            $user->setName($data['name'])
                ->setEmail($data['email'])
                ->setPassword($data['password']);
            $usersDAO->insertUser($user);

            $payload = json_encode(['message' => 'User created.']);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        } catch (\InvalidArgumentException $ex) {

            $payload = json_encode(['error' => \InvalidArgumentException::class,
                'status' => 400,
                'code' => '002',
                'userMessage' => "Invalid Argument.",
                'developerMessage' => $ex->getMessage()]);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);


        } catch (\Exception | \Throwable $ex) {
            $payload = json_encode(['error' => \Exception::class,
                'status' => 500,
                'code' => '001',
                'userMessage' => "Application error.",
                'developerMessage' => $ex->getMessage()]);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);

        }
    }

    public function login(array $args)
    {

        $email = $args['user'];
        $password = $args['password'];

        $usersDAO = new UsersDAO();
        $user = $usersDAO->getUserByEmail($email);

        if (is_null($user)) {
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        $_SESSION['userId'] = $user->getId();
        $_SESSION['userName'] = $user->getName();
        $_SESSION['userEmail'] = $user->getEmail();

        return true;

    }
}
