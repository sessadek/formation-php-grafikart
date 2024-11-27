<?php

use App\Auth;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {

    /**
     * Undocumented variable
     *
     * @var Auth
     */
    private $auth;

    private $session = [];

    public function setAuthMemory() {
        $pdo = new PDO("sqlite::memory:", null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $statement = "CREATE TABLE users (username TEXT, password TEXT,role TEXT)"; // id INTEGER PRIMARY KEY AUTOINCREMENT, 

        $pdo->query($statement);

        $query = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");

        $users = ['admin', 'user'];

        foreach($users as $user) {
            $query->execute([
                $user,
                password_hash($user, PASSWORD_BCRYPT),
                $user,
            ]);
        }
        $this->auth = new Auth($pdo, 'login.php', $this->session);

        return $this->auth;
    }

    /**
     * @before
     */

    public function setAuth() {
        $driver = 'sqlite';
        $db = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data.sqlite';
        if(!file_exists($db)) {
            echo "The database doesn't exists";
        }
        $root = "$driver:$db";
        $pdo = new PDO($root, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        $this->auth = new Auth($pdo, 'login.php', $this->session);

        return $this->auth;
    }

    public function testLoginWithBadUsername() {
        $this->assertNull($this->auth->login('user', 'aze'));
    }

    public function testLoginWithBadUserPassword() {
        $this->assertNull($this->auth->login('user', 'aze'));
    }

    public function testLoginSuccess() {
        $this->assertObjectHasProperty('username', $this->auth->login('admin', 'admin'));
        $this->assertEquals(1, $this->session['user']);
    }

    public function testUserWhenNotConnected() {
        $this->assertNull($this->auth->user());
    }

    public function testUserWhenConnectedWithFailureSession() {
        $this->session['user'] = 11;
        $this->assertNull($this->auth->user());
    }

    public function testUserWhenConnected() {
        $this->session['user'] = 1;
        $user = $this->auth->user();
        $this->assertIsObject($user);
        $this->assertEquals('admin', $user->username);
    }

    public function testRequireRole() {
        $this->session['user'] = 2;
        $this->auth->requireRole('user');
        $this->expectNotToPerformAssertions();
    }

    public function testRequireRoleThrowException () {
        $this->expectException(App\Exception\ForbiddenException::class);
        $this->session['user'] = 2;
        $this->auth->requireRole('admin');
    }

    public function testRequireRoleWithoutLoginThrowException () {
        $this->expectException(App\Exception\ForbiddenException::class);
        $this->auth->requireRole('user3333');
    }

}