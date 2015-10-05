<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/3/2015
 * Time: 10:46 PM
 */
namespace models;

use base;

class Users extends base\Models
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Insert into users width $data
     *
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("users") . "(
                                                                  user_name,
                                                                  user_pass,
                                                                  salt,
                                                                  user_email,
                                                                  roles_id
                                                                  )
                      VALUES (?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssi",
            $data['user_name'],
            $data['user_pass'],
            $data['salt'],
            $data['user_email'],
            $data['roles_id']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Delete FROM users Where $user_id
     *
     * @param $user_id
     * @return bool
     */
    public function delete($user_id)
    {
        $sql = "DELETE FROM " . $this->getTableName("users") . " WHERE user_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Update users name SET = $data Where $user_id
     *
     * @param $data
     * @param $user_id
     * @return bool
     */
    public function update($data, $user_id)
    {
        if (!isset($data['user_pass']) || $data['user_pass'] == "") {
            $result = $this->updateNonPass($data, $user_id);
        } else {
            $sql = "UPDATE " . $this->getTableName("users") . "
                    SET user_name = ?,
                        user_email = ?,
                        user_pass = ?,
                        salt = ?,
                        roles_id = ?
                    WHERE user_id = ?";

            $stmt = $this->prepare($sql);
            $stmt->bind_param("ssssii", $data['user_name'],
                $data['user_email'],
                $data['user_pass'],
                $data['salt'],
                $data['roles_id'],
                $user_id);
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }

    /**
     * Update users but non change pass
     *
     * @param $data
     * @param $user_id
     * @return bool
     */
    public function updateNonPass($data, $user_id)
    {
        $sql = "UPDATE " . $this->getTableName("users") . "
                SET user_name = ?,
                    user_email = ?,
                    roles_id = ? WHERE user_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssii", $data['user_name'],
            $data['user_email'],
            $data['roles_id'],
            $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * SELECT * FROM users where $user_id
     *
     * @param $user_id
     * @return array
     */
    public function select($user_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("users") . " WHERE user_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT * FROM users Where $user_email (check email when register)
     *
     * @param $user_email
     * @return array
     */
    public function selectByEmail($user_email)
    {
        $sql = "SELECT * FROM " . $this->getTableName("users") . " WHERE user_email=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT * FROM users Where $user_email and user_id <> $user_id (check email when update users)
     *
     * @param $user_id
     * @param $user_email
     * @return array
     */
    public function selectByEmailNotID($user_email, $user_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("users") . " WHERE user_email=? AND user_id<>?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("si", $user_email, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT * FROM users
     *
     * @return array
     */
    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName("users") . " as users,
                                " . $this->getTableName("users_roles") . " as usersroles
                WHERE users.roles_id = usersroles.roles_id";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * SELECT * FROM users where $user_email and $user_pass (Process for login page)
     *
     * @param $user_email
     * @param $user_pass
     * @return array
     */
    public function login($user_email, $user_pass)
    {
        $sql = "SELECT * FROM " . $this->getTableName("users") . " WHERE user_email=? AND user_pass=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ss", $user_email, $user_pass);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }
}