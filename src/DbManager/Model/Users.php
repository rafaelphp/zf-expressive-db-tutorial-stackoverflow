<?php

namespace DbManager\Model;


/**
 * Class Users
 * @package DbManager\Model
 */
class Users
{

    /**
     * @var
     */
    public $users_id;
    /**
     * @var
     */
    public $users_username;
    /**
     * @var
     */
    public $users_password;
    /**
     * @var
     */
    public $users_status;

    /**
     * @param $data
     */
    public function exchangeArray($data )
    {
        $this->users_id        = (!empty($data['users_id']))       ? $data['users_id']       : null;
        $this->users_username  = (!empty($data['users_username'])) ? $data['users_username'] : null;
        $this->users_password  = (!empty($data['users_password'])) ? $data['users_password'] : null;
        $this->users_status    = (!empty($data['users_status']))   ? $data['users_status']   : null;
    }

}