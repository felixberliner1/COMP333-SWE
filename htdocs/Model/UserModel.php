<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM login ORDER BY username ASC LIMIT ?", 
            [['type' => 'i', 'value' => $limit]]);
    }

    public function getUserByUsername($username)
    {
        return $this->select("SELECT * FROM login WHERE username = ? LIMIT 1", 
            [['type' => 's', 'value' => $username]]);
    }

    public function createUser($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->executeStatement(
            "INSERT INTO login (username, password) VALUES (?, ?)",
            [
                ['type' => 's', 'value' => $username],
                ['type' => 's', 'value' => $hashedPassword]
            ]
        );
        return $this->connection->insert_id;
    }
}