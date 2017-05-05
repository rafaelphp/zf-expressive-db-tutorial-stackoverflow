<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', Model\Model\HomePageAction::class, 'home');
 * $app->post('/album', Model\Model\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', Model\Model\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', Model\Model\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', Model\Model\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', Model\Model\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', Model\Model\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     Model\Model\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */


$app->get('/', App\Action\HomePageAction::class, 'home');
$app->get('/api/ping', App\Action\PingAction::class, 'api.ping');


