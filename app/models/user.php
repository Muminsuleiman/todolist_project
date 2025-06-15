<?php
include_once __DIR__ . "/dbConnect.php";
include_once __DIR__ . "/BaseModel.php";

class UserModel extends BaseModel {
    private $id;
    public $username;
    public $password;
    public $role;

    function __construct() {
        $this->username = "";
        $this->password = "";
        $this->role = "user";
        $this->id = null;
    }

    public static function initializeDatabase() {
        global $pdo;
        $pdo->prepare(
            "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL DEFAULT 'user'
            );"
        )->execute();
    }

    public function getID() { return $this->id; }

    public function save() {
        global $pdo;
        if ($this->id != null) {
            $stmt = $pdo->prepare("UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id");
            $stmt->execute([
                ':username' => $this->username,
                ':password' => $this->password,
                ':role' => $this->role,
                ':id' => $this->id
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
            $stmt->execute([
                ':username' => $this->username,
                ':password' => $this->password,
                ':role' => $this->role
            ]);
            $this->id = $pdo->lastInsertId();
        }
    }

    public function delete() {
        global $pdo;
        if (!$this->id) throw new Exception("User doesn't exist in db");
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $this->id]);
        $this->id = null;
        $this->username = null;
        $this->password = null;
        $this->role = null;
    }

    public static function load($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;
        return self::loadSingleResult($data);
    }

    public static function getAll() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($data as $item) {
            $users[] = self::loadSingleResult($item);
        }
        return $users;
    }

    public static function loadByUsername($username) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;
        return self::loadSingleResult($data);
    }

    public static function loadSingleResult($data) {
        $user = new UserModel();
        $user->id = $data["id"];
        $user->username = $data["username"];
        $user->password = $data["password"];
        $user->role = $data["role"];
        return $user;
    }
}
?>