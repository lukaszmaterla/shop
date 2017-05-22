<?php

/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 22.05.17
 * Time: 16:51
 */
abstract class ActiveRecord
{
    protected $id;
    protected static $db;

    public function __construct()
    {
        self::connect();

    }
    public static function connect()
    {
        if (!self::$db){
            self::$db = new db();
            self::$db->changeDB('shop');

        }
        return true;
    }
    public function save(){}
}