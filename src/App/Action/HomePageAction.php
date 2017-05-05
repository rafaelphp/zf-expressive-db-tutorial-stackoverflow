<?php

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;

use Psr\Http\Message\ServerRequestInterface;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\ZendView\ZendViewRenderer;

use DbManager\Table;



/**
 * Class HomePageAction
 * @package Model\Model
 */
class HomePageAction implements ServerMiddlewareInterface
{
    /**
     * @var Router\RouterInterface
     */
    private $router;

    /**
     * @var null|Template\TemplateRendererInterface
     */
    private $template;

    /**
     * @var Table\UsersTable
     */
    private $usersTable;



    /**
     * HomePageAction constructor.
     * @param Router\RouterInterface $router
     * @param Template\TemplateRendererInterface|null $template
     * @param UsersTable $usersTable
     */
    public function __construct( Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, Table\UsersTable $usersTable )
    {
        $this->router     = $router;
        $this->template   = $template;
        $this->usersTable = $usersTable;

    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return HtmlResponse|JsonResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {


	$user = $this->usersTable->getById(1);


        if ( $this->template) {
            return new JsonResponse([
                'welcome' => 'Congratulations! You have installed the skeleton application.',
                'user' => $user
            ]);
        }


    }
}
