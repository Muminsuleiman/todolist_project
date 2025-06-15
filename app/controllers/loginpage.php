<?php
include_once __DIR__ . "/../models/user.php";
include_once __DIR__ . "/../views/login.php";
session_start();

class LoginPageController {
    public static function execute() {
        UserModel::initializeDatabase();

        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = UserModel::loadByUsername($username);
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->getID();
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;
                header("Location: /todolist_project/public/index.php");
                exit;
            } else {
                $error = "Invalid username or password";
            }
        }
        LoginView::render($error);
    }
}
?>