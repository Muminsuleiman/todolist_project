<?php
include_once __DIR__ . "/dbConnect.php";
include_once __DIR__ . "/BaseModel.php";

class CategoryModel extends BaseModel {
    private $id;
    public $name;

    function __construct() {
        $this->name = "";
        $this->id = null;
    }

    public static function initializeDatabase() {
        global $pdo;
        $pdo->prepare(
            "CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL
            );"
        )->execute();
    }

    public function getID() { return $this->id; }

    public function save() {
        global $pdo;
        if ($this->id != null) {
            $stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
            $stmt->execute([':name' => $this->name, ':id' => $this->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute([':name' => $this->name]);
            $this->id = $pdo->lastInsertId();
        }
    }

    public function delete() {
        global $pdo;
        if (!$this->id) throw new Exception("Category doesn't exist in db");
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute([':id' => $this->id]);
        $this->id = null;
        $this->name = null;
    }

    public static function load($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;
        return self::loadSingleResult($data);
    }

    public static function getAll() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cats = [];
        foreach ($data as $item) {
            $cats[] = self::loadSingleResult($item);
        }
        return $cats;
    }

    public static function loadSingleResult($data) {
        $cat = new CategoryModel();
        $cat->id = $data["id"];
        $cat->name = $data["name"];
        return $cat;
    }
}
?>