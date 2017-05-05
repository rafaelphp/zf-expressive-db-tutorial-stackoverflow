<?php

namespace DbManager\Table;

use DbManager\Table\Helper\DbHydratorFactory;
use DbManager\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;
use Zend\Validator\EmailAddress;


use RuntimeException;

/**
 * Class UsersTable
 * @package DbManager\Table
 */
class UsersTable extends DbHydratorFactory
{

    /**
     *   user prefix to validate into account, this can be replaced with another prefix, no problem
     */
    const USERNAME_PREFIX      = "user";
    /**
     *
     */
    const CHECK_AUTH_DEVICE_ID = null;

    /**
     * @var array
     */
    private $insert_date;

    /**
     * @var array
     */
    private $update_date;

    /**
     * @var string
     */
    private $primary_id;

    /**
     * @param $string
     * @return mixed
     */
    private function formatRemoveSymbols($string) {
        $contain  = ['.','-','_','~','!','@','#','$','%','^','&','*','(',')',';',':',"'",'"','{','}','[',']','+',"-"];
        $removed  = str_replace($contain,'',$string);
        return $removed;
    }

    /**
     * @param null $len
     * @param null $hasInt
     * @return string
     */
    private function getNewUsername($len = null , $hasInt = null )
    {

        if ( is_null($len) ){
            $len = 6;
        }

        $prefix    = self::USERNAME_PREFIX;
        $new_array = [];
        $string    = "ABCDEFGHIJKLMNOPQRSTUVXZ";
        $int       = "0123456789";
        if ( !is_null($hasInt) ) {
            $string = $string . $int;
        }
        for ($i=0; $i<=$len; $i++) :
            $new_array[$i] = $string[rand()%strlen($string)];
        endfor;
        shuffle($new_array);
        return $prefix.join('',$new_array);

    }

    /**
     * UsersTable constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        parent::__construct($tableGateway);
        $this->primary_id   = 'users_id';
        $this->insert_date  = ['users_insert_date'=>$this->getCurrentDate()];
        $this->update_date  = ['users_update_date'=>$this->getCurrentDate()];
    }


    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    /**
     * @param array $where
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchWhere(Array $where)
    {
        $rowSet = $this->tableGateway->select($where);
        return $rowSet;
    }

    /**
     * @param $id
     * @return object
     */
    public function getById($id)
    {
        $id     = (int) $id;

        $sql   = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(
            ['a'=> $this->table]
        );
        // comment this to disable users_group data
        $select->join(
            ['b'=>'users_group'],
            "a.users_group_id = b.users_group_id"
        );

        $select->where(function(Where $where) use ($id){
            $where->equalTo('a.users_id',$id);
        });
        $prepare = $sql->prepareStatementForSqlObject($select);
        $res     = $prepare->execute();
        $hydrate = $this->hydrate($res, new Model\Hydrate\UsersaGroupb() );
        $row     = $hydrate->current();

        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }
        return $row;
    }

    /**
     * @param $username
     * @return null|object
     */
    public function getRowByUsername($username)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select();

        $select->from(
            ['a'=> $this->table ]
        );
        $select->join(
            ['b'=>"users_group"] ,
            "a.users_group_id = b.users_group_id" ,
            ['users_group_name','users_group_status']
        );

        $select->where(function(Where $where) use ($username) {
            $where->equalTo('a.users_username',$username);
        });

        $prepare    = $sql->prepareStatementForSqlObject($select);
        $res        = $prepare->execute();
        $hydrateRes = $this->hydrate( $res, new Model\Hydrate\UsersaGroupb() );

        if($hydrateRes->count() <= 0){
            return null;
        } else {
            $current    = $hydrateRes->current();
            return $current;
        }

    }

    /**
     * @param $email
     * @return null|object
     */
    public function getRowByEmail($email)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from( ['a'=>$this->tableGateway->getTable()] )
            ->join( ['b'=>"users_group"] , "a.users_group_id = b.users_group_id" , ['users_group_name','users_group_status'])
            ->where(function(Where $where) use ($email) {
                $where->equalTo('a.users_email',$email);
            });
        $prepare = $sql->prepareStatementForSqlObject($select);
        $res     = $prepare->execute();

        $hydrateRes = $this->hydrate( $res, new Model\Hydrate\UsersaGroupb() );
        if( $hydrateRes->count() <= 0){
            return null;
        }
        else {
            $current    = $hydrateRes->current();
            return $current;
        }
    }

    /**
     * @param $type
     * @param $val
     * @return null|object|\Zend\Db\ResultSet\HydratingResultSet
     */
    public function checkUserBy($type, $val)
    {

        $validateEmail = new EmailAddress();
        $value         = trim($val);

        if( $type == 'username' ) {
            $field = 'users_username';
        }
        elseif( $type=='email' ) {
            $field = 'users_email';
            if( !$validateEmail->isValid($value) ){
                $value = time();
            }
        }
        else {
            $field = $type;
        }

        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from(
            ['a'=>$this->table]
        );
        $select->join(
            ['b'=>'users_group'],
            "a.users_group_id = b.users_group_id"
        );
        $select->where(function(Where $where) use($field,$value) {
            $where->equalTo($field,$value);
        });
        $sttm = $sql->prepareStatementForSqlObject($select);
        $res  = $sttm->execute();
        $hydrate = $this->hydrate( $res , new Model\Hydrate\UsersaGroupb() );

        if ( $hydrate->count() <= 0 ){
            return null;
        }
        elseif( $hydrate->count() == 1) {
            return $hydrate->current();
        }
        else {
            return $hydrate;
        }
    }

    /**
     * @param $type
     * @param $val
     * @return null|object|\Zend\Db\ResultSet\HydratingResultSet
     */
    public function getUserBy($type, $val)
    {
        return self::checkUserBy($type,$val);
    }

    /**
     * @param $data
     * @return bool|int|null
     */
    public function save($data)
    {

        @$id = ( isset($data[$this->primary_id]) ) ? (int)$data[$this->primary_id] : false;
        if ($id === false) {
            $checkUsername = $this->getRowByUsername( $data['users_username']);
            if( !isset($checkUsername) ) {
                #$data = array_merge($data, $this->insert_date);
                $this->tableGateway->insert($data);
                $this->logs(5,'user','insert',$data);
                return $this->tableGateway->lastInsertValue;
            }
            else {
                $this->logs(5,'user',"not-inserted::user-already-exist",$data);
                return null;
            }
        }
        else {
            if (!$this->getById($id)) {
                throw new RuntimeException(sprintf(
                    'Cannot update with identifier %d; does not exist',
                    $id
                ));
            }
            #$data = array_merge($data, $this->update_date);
            $this->tableGateway->update($data, array($this->primary_id => $id));
            $this->logs(5,'user','update',$data);
            return $id;
        }

    }

    /**
     * @param array $data
     * @return bool
     */
    public function delete(Array $data) {
        if ( $this->tableGateway->delete([ $data[0] => (int) $data[1]]) ){
            return true;
        }
        else {
            return null;
        }
    }



}
