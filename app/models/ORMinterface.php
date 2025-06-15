<?php
interface ORMinterface {
    public function save();
    public function delete();
    public function getID();
    public static function load($id);
    public static function getAll();
}
?>