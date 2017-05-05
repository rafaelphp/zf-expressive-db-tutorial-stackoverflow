<?php
/**
 * Created by PhpStorm.
 * User: webmaster
 * Date: 07/11/16
 * Time: 10:04 AM
 */

namespace DbManager\Model\Hydrate;


class UsersaGroupb
{

    public $users_id;
    public $users_username;
    public $users_password;
    public $users_status;


    public $users_group_name;
    public $users_group_status;

    public function exchangeArray( array $data )
    {
        $this->users_id            = (!empty($data['users_id']))       ? $data['users_id']       : null;
        $this->users_username      = (!empty($data['users_username'])) ? $data['users_username'] : null;
        $this->users_password      = (!empty($data['users_password'])) ? $data['users_password'] : null;
        $this->users_status        = (!empty($data['users_status']))   ? $data['users_status']   : null;

        $this->users_group_name    = !empty($data['users_group_name'])   ? $data['users_group_name']   : null;
        $this->users_group_status  = !empty($data['users_group_status']) ? $data['users_group_status'] : null;

    }

}