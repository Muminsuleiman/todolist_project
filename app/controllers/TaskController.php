<?php
require_once 'app/models/Task.php';

class TaskController {
    private $task;

    public function __construct() {
        $this->task = new Task();
    }

    public function index() {
        $tasks = $this->task->getAll();
        require 'app/views/tasks/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title'])) {
            $this->task->create($_POST['title']);
        }
        header('Location: /');
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->task->delete($_GET['id']);
        }
        header('Location: /');
    }
}
