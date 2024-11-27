<?php

namespace App;

use App\Exception\ForbiddenException;
use PDO;
use App\User;
use Exception;

class Auth {

    private $pdo;

    private $path;

    private $session;

    public function __construct(PDO $pdo, string $path, array &$session)
    {
        $this->pdo = $pdo;
        $this->path = $path;
        $this->session = &$session;
    }
    
    public function login(string $username, string $password)
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $query->execute(['username' => $username]);
        $user = $query->fetchObject(User::class);
        
        if($user ===  false) {
            return null;
        }
        if (password_verify($password, $user->password)) {
            $this->session['user'] = $user->id;
            return $user;
        }
        return null;
    }

    public function requireRole(string ...$roles): void
    {   
        $user = $this->user();
        if(is_null($user)) {
            throw new ForbiddenException("Vous devez être connecté pour voir cette page");
        }

        if(!in_array($user->role, $roles)) {
            $role = $user->role;
            $roles = implode(",", $roles);
            throw new ForbiddenException("Vous n'avez pas le rôle suffisant \"$role\" (attendu: \"$roles\")  ");
        }
    }

    public function user(): ?User
    {
        $id = $this->session['user'] ?? null;
        if(is_null($id)) {
            return null;
        }
        $query = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $query->execute(['id' => $id]);
        $user = $query->fetchObject(User::class);
        return $user ?: null;
    }
}