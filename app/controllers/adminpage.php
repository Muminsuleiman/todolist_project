<?php
include_once __DIR__ . "/../models/user.php";
include_once __DIR__ . "/../views/admin.php";
session_start();

class AdminPageController {
    public static function execute() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: /todolist_project/public/index.php");
            exit;
        }
        $users = UserModel::getAll();
        AdminView::render($users);
    }
}
?>