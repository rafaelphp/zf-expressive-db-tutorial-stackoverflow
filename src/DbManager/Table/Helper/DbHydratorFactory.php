<?php
/**
 * Created by PhpStorm.
 * User: webmaster
 * Date: 01/12/16
 * Time: 01:19 PM
 */

namespace DbManager\Table\Helper;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;

use Zend\Hydrator\Reflection as ReflectionHydrator;

/**
 * Class DbHydratorFactory
 * @package DbManager\Table\Helper
 */
class DbHydratorFactory
{

    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * @var Adapter
     */
    protected $dbAdapter;


    /**
     * DbHydratorFactory constructor.
     * @param TableGateway $tableGateway
     */
    protected function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway   = $tableGateway;
        $this->dbAdapter      = $this->tableGateway->getAdapter();
        $this->table          = $this->tableGateway->getTable();
        $this->tableColumns   = $this->tableGateway->getColumns();
    }

    /**
     * @return bool|string
     */
    protected function getCurrentDate()
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * @param $result
     * @param $model
     * @return HydratingResultSet
     */
    protected function hydrate($result, $model)
    {
        $resultSet = new HydratingResultSet( new ReflectionHydrator, $model );
        $resultSet->initialize($result);
        return $resultSet;
    }

}