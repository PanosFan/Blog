<?php

class Dbh
{
    private $dsn = "mysql:host=localhost;dbname=php-api-blog";
    private $name = 'root';
    private $password = '';

    protected function connect()
    {
        try {
            $pdo = new PDO($this->dsn, $this->name, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Error connecting: " . $e->getMessage();
            die();
        }
    }
}