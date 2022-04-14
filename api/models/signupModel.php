<?php

class Signup extends Dbh
{

    public function signupUser($name, $surname, $password, $email)
    {
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users SET name=?, surname=?, email=?, password=?, created_at=CURRENT_TIMESTAMP";
        $statement = $this->connect()->prepare($sql);
        if (!$statement->execute([$name, $surname, $email, $hashpassword])) {
            $statement = null;
            die();
        }
        return $statement;
    }

    public function checkUser($email)
    {
        $sql = "SELECT * FROM users WHERE email=?";
        $statement = $this->connect()->prepare($sql);
        if (!$statement->execute([$email])) {
            $statement = null;
            die();
        }
        if ($statement->rowCount() > 0) {
            return true;
        }
        return false;
    }
}