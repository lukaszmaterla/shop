<?php

/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 22.05.17
 * Time: 16:56
 */
class Db
{
    private $host = null;
    private $user = null;
    private $pass = null;
    private $conn = null;

    public function __construct($host = "localhost", $user = "root", $pass = "codeslab")
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;

        try{
            $this->conn = new PDO("mysql:host=$host", $user, $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ATTR_ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);

        }catch (Exception $e){
            echo "Uwaga: ".$e->getMessage()."<br>";
        }
    }

    public function changeDB($name)
    {
        try{
            $this->conn->exec("use $name");

        }   catch (Exception $e){
            echo "Uwaga: ".$e->getMessage(). "<br>";
            return false;
        }
        return true;
    }


}