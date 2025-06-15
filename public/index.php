<?php
include_once __DIR__ . "/../app/models/category.php";
CategoryModel::initializeDatabase();

include_once __DIR__ . "/../app/controllers/todopage.php";
TodoPageController::execute();
?>