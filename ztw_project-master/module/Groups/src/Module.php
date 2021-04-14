<?php
namespace Groups;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\GroupsTable::class        => function ($container) {
                    $tableGateway = $container->get('Model\GroupsTableGateway');
                    
                    return new Model\GroupsTable($tableGateway);
                },
                'Model\GroupsTableGateway' => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Groups());

                    return new TableGateway('groups', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\GroupsController::class => function ($container) {
                    return new Controller\GroupsController(
                        $container->get(Model\GroupsTable::class)
                    );
                },
            ],
        ];
    }
}