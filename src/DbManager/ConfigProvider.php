<?php
/**
 * Created by PhpStorm.
 * User: webmaster
 * Date: 28/03/17
 * Time: 05:55 PM
 * The configuration provider for the DbManager module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
namespace DbManager;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;


class ConfigProvider
{

    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                Table\UsersTable::class => function($container) {
                    $dbAdapter          = $container->get( AdapterInterface::class );
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype( new Model\Users() );
                    $tableGateway       = new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                    return new Table\UsersTable($tableGateway);
                },
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [];
    }

}