<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/9/2015
 * Time: 9:41 AM
 */

namespace library;


class Alert
{
    const TYPE_SUCCESS = "success";
    const TYPE_INFO = "info";
    const TYPE_WARNING = "warning";
    const TYPE_DANGER = "danger";


    private $_type;
    private $_dismissible;
    private $_message;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
        if ($type != self::TYPE_SUCCESS
            || $type != self::TYPE_INFO
            || $type != self::TYPE_DANGER
            || $type != self::TYPE_WARNING
        ) {
            $this->_type = self::TYPE_SUCCESS;
        }
    }

    /**
     * @return mixed
     */
    public function getDismissible()
    {
        return $this->_dismissible;
    }

    /**
     * @param mixed $dismissible
     */
    public function setDismissible($dismissible)
    {
        $this->_dismissible = boolval($dismissible);
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->_message = $message;
    }

    public function __construct()
    {
        $this->_type = self::TYPE_SUCCESS;
        $this->_dismissible = true;
    }

    public function toString($message = "")
    {
        if ($message != "") {
            $this->setMessage($message);
        }

        $result = '<div class="alert alert-' . $this->getType();
        if($this->_dismissible == true) {
            $result .= " alert-dismissible";
        }
        $result .= '" role="alert">';
        $result .= ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        $result .= $this->getMessage();
        $result .= '</div>';
        return $result;
    }
}