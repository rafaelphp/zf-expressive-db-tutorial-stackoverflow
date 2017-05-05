<?php

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

use DbManager\Table;

class HomePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class) ? $container->get(TemplateRendererInterface::class) : null;

        $usersTable = $container->get( Table\UsersTable::class );

        return new HomePageAction($router, $template,$usersTable);
    }
}
