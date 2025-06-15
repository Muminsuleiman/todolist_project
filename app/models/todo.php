<?php
include_once __DIR__ . "/dbConnect.php";
include_once __DIR__ . "/BaseModel.php";

class TodoModel extends BaseModel {
    private $id;
    public $title;
    public $description;
    public $completed;
    public $user_id;
    public $category_id;

    function __construct() {
        $this->title = "";
        $this->description = "";
        $this->completed = false;
        $this->user_id = null;
        $this->category_id = null;
        $this->id = null;
    }

    public static function initializeDatabase() {
        global $pdo;
        $pdo->prepare(
            "CREATE TABLE IF NOT EXISTS todos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                completed BOOLEAN NOT NULL DEFAULT 0,
                user_id INT,
                category_id INT,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (category_id) REFERENCES categories(id)
            );"
        )->execute();
    }

    public function getID() { return $this->id; }

    public function save() {
        global $pdo;
        if ($this->id != null) {
            $stmt = $pdo->prepare("UPDATE todos SET title = :title, description = :description, completed = :completed, user_id = :user_id, category_id = :category_id WHERE id = :id");
            $stmt->execute([
                ':title' => $this->title,
                ':description' => $this->description,
                ':completed' => $this->completed,
                ':user_id' => $this->user_id,
                ':category_id' => $this->category_id,
                ':id' => $this->id
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO todos (title, description, completed, user_id, category_id) VALUES (:title, :description, :completed, :user_id, :category_id)");
            $stmt->execute([
                ':title' => $this->title,
                ':description' => $this->description,
                ':completed' => $this->completed,
                ':user_id' => $this->user_id,
                ':category_id' => $this->category_id
            ]);
            $this->id = $pdo->lastInsertId();
        }
    }

    public function delete() {
        global $pdo;
        if (!$this->id) throw new Exception("Item doesn't exist in db");
        $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
        $stmt->execute([':id' => $this->id]);
        $this->id = null;
        $this->title = null;
        $this->description = null;
        $this->completed = null;
        $this->user_id = null;
        $this->category_id = null;
    }

    public static function load($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM todos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;
        return self::loadSingleResult($data);
    }

    public static function getAll() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM todos");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $todos = [];
        foreach ($data as $item) {
            $todos[] = self::loadSingleResult($item);
        }
        return $todos;
    }

    public static function getAllByUser($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM todos WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $todos = [];
        foreach ($data as $item) {
            $todos[] = self::loadSingleResult($item);
        }
        return $todos;
    }

    public static function loadSingleResult($data) {
        $todoItem = new TodoModel();
        $todoItem->id = $data["id"];
        $todoItem->title = $data["title"];
        $todoItem->description = $data["description"];
        $todoItem->completed = (bool)$data["completed"];
        $todoItem->user_id = $data["user_id"];
        $todoItem->category_id = $data["category_id"];
        return $todoItem;
    }
}
?>