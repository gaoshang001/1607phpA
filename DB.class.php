<?php

class DB{
    private static $ins;
    private static $db;

    private function __construct($config){
        list($ip,$dbname,$username,$password) = $config;
        self::$db = new PDO("mysql:host=$ip;dbname=$dbname",$username,$password);
    }

    private function __clone(){

    }

    public static function getIns(...$config){
        if(self::$ins instanceof SELF){
            echo self::$ins;
        }
        return self::$ins = new SELF($config);
    }

    function create($sql){
        return self::$db->exec($sql);
    }
    function select($sql){
        return self::$db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    function find($sql){
        return self::$db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    function update($sql){
        return self::$db->exec($sql);
    }
    function delete($sql){
        return self::$db->exec($sql);
    }
}
$config = ['127.0.0.1','test','root','root'];
$object = DB::getIns(...$config);
$res = $object->delete("delete  from month_user where id = 4");
//echo "<pre>";
////var_dump($res);