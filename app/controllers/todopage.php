<?php
include_once __DIR__ . "/../models/user.php";
include_once __DIR__ . "/../models/category.php";
include_once __DIR__ . "/../models/todo.php";
include_once __DIR__ . "/../views/todo.php";
session_start();

class TodoPageController {
    public static function execute() {
        UserModel::initializeDatabase();
        CategoryModel::initializeDatabase();
        TodoModel::initializeDatabase();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /todolist_project/public/index.php");
            exit;
        }

                // === Toevoegen: taak opslaan als formulier is verzonden ===
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
            $todo = new TodoModel();
            $todo->title = $_POST['title'];
            $todo->description = $_POST['description'];
            $todo->completed = false;
            $todo->user_id = $_SESSION['user_id'];
            $todo->category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;
            $todo->save();
            // Refresh om dubbele submit te voorkomen
            header("Location: index.php");
            exit;
        }
        // === Einde toevoegen ===

        $todos = TodoModel::getAllByUser($_SESSION['user_id']);
        $categories = CategoryModel::getAll();
        TodoView::render($todos, $categories);
    }
}
?>
