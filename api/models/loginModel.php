<?php

class Login extends Dbh
{
    public function loginUser($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email=?";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$email]);
        return $statement;
    }
}