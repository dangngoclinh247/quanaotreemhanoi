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
     * @return mixed
     */
    public function getTableName($name)
    {
        return DB_TABLE_PREFIX . $name;
    }

    public function fetch_assoc_all(\mysqli_result $result)
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