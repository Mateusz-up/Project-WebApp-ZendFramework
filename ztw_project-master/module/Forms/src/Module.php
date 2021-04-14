<?php
namespace Forms;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Groups\Model\GroupsTable;
use Groups\Model\Groups;

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
                Model\FormsTable::class => function($container) {
                    $tableGateway = $container->get(Model\FormsTableGateway::class);
                    return new Model\FormsTable($tableGateway);
                },
                Model\FormsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Forms());
                    return new TableGateway('forms', $dbAdapter, null, $resultSetPrototype);
                },
                GruopsTable::class => function($container) {
                    $tableGateway = $container->get(GroupsTableGateway::class);
                    return new GroupsTable($tableGateway);
                },
                GroupsTableGateway::class => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Groups());

                    return new TableGateway('groups', $dbAdapter, null, $resultSetPrototype);
                },
                Model\FormGroupTable::class => function($container) {
                    $tableGateway = $container->get(Model\FormGroupTableGateway::class);
                    return new  Model\FormGroupTable($tableGateway);
                },
                Model\FormGroupTableGateway::class => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\FormGroup());

                    return new TableGateway('formgroup', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\FormsController::class => function($container) {
                    return new Controller\FormsController(
                        $container->get(Model\FormsTable::class),
                        $container->get(GroupsTable::class),
                        $container->get(Model\FormGroupTable::class)
                    );
                },
            ],
        ];
    }
}
?>
