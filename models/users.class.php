<?php
namespace models;

use base;

class Users extends base\Models
{
    public function __construct()
    {
        parent::__construct();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->getTableName("users") . " WHERE user_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update($data, $id)
    {
        if (!isset($data['user_pass']) || $data['user_pass'] == "") {
            $result = $this->updateNonPass($data, $id);
        } else {
            $sql = "UPDATE " . $this->getTableName("users") . "
                SET user_name = ?,
                    user_email = ?,
                    user_pass = ?,
                    roles_id = ? WHERE user_id = ?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("sssii", $data['user_name'],
                $data['user_email'],
                $data['user_pass'],
                $data['roles_id'],
                $id);
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }

    public function updateNonPass($data, $id)
    {
        $sql = "UPDATE " . $this->getTableName("users") . "
                SET user_name = ?,
                    user_email = ?,
                    roles_id = ? WHERE user_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssii", $data['user_name'],
            $data['user_email'],
            $data['roles_id'],
            $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("users") . "(user_id, user_name, user_pass, user_email, roles_id)
                      VALUES (NULL,?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssi",
            $data['user_name'],
            $data['user_pass'],
            $data['user_email'],
            $data['roles_id']
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function select($id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("users") . " WHERE user_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName("users") . " as users, " . $this->getTableName("users_roles") . " as usersroles
                WHERE users.roles_id = usersroles.roles_id";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }
}