<?php

namespace base;

class Models extends \mysqli
{

    public function __construct()
    {
        parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($this->connect_error != 0)
            die("Connect error: " . $this->connect_error);
    }

    /**
     * Convert string "" -> null
     *
     * @param $str
     * @return null|string
     */
    protected function trim($str)
    {
        $str = trim($str);
        if ($str == "") {
            $str = null;
        }
        return $str;
    }

    /**
     * return full table name: prefix and name
     *
     * @return mixed
     */
    protected function getTableName($name)
    {
        return DB_TABLE_PREFIX . $name;
    }

    /**
     * fetch assoc all row of mysqli_result
     *
     * @param \mysqli_result $result
     * @return array
     */
    protected function fetch_assoc_all(\mysqli_result $result)
    {
        $data = array();
        while($row = $result->fetch_assoc())
        {
            $data[] = $row;
        }
        return $data;
    }

    public function __destruct()
    {
        $this->close();
    }
}