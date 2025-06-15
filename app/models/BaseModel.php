<?php
include_once __DIR__ . "/ORMinterface.php";

abstract class BaseModel implements ORMinterface {
    abstract public function save();
    abstract public function delete();
    abstract public function getID();
    public static function load($id) {}
    public static function getAll() {}
}
?>