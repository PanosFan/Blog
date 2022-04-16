<?php

class Post extends Dbh
{
    public function read()
    {
        $sql = "SELECT u.name, u.user_id, u.surname, p.post_id, p.title, p.body FROM users AS u INNER JOIN posts AS p ON u.user_id = p.user_id";
        $statement = $this->connect()->prepare($sql);
        if (!$statement->execute()) {
            $statement = null;
            die();
        }
        return $statement;
    }

    public function read_by_user($user)
    {
        $sql = "SELECT u.name, u.user_id, u.surname, p.post_id, p.title, p.body FROM users AS u INNER JOIN posts AS p ON u.user_id = p.user_id WHERE u.name=?";
        $statement = $this->connect()->prepare($sql);
        if (!$statement->execute([$user])) {
            $statement = null;
            die();
        }
        return $statement;
    }

    public function create($title, $body)
    {
        $sql = "INSERT INTO posts SET user_id = ?, title = ?, body = ?, created_at = CURRENT_TIMESTAMP, updated_at = NULL";
        $statement = $this->connect()->prepare($sql);
        if (!$statement->execute([$_SESSION['user_id'], $title, $body])) {
            $statement = null;
            die();
        }
        return $this->read();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM posts WHERE post_id = ?";
        $statement = $this->connect()->prepare($sql);
        if (!$statement->execute([$id])) {
            $statement = null;
            die();
        }
        return $this->read();
    }

    public function update($id, $title, $body)
    {
        $sql = "UPDATE  posts SET  title = ?, body = ?, updated_at = CURRENT_TIMESTAMP WHERE post_id = ?";
        $statement = $this->connect()->prepare($sql);
        if (!$statement->execute([$title, $body, $id])) {
            $statement = null;
            die();
        }
        return $this->read();
    }
}