<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Redirect to Swagger documentation
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

    // API
    $app->group(
        '/api/v1',
        function (RouteCollectorProxy $app) {
            $app->get('/customers', \App\Action\Customer\CustomerFinderAction::class);
            $app->post('/customers', \App\Action\Customer\CustomerCreatorAction::class);
            $app->get('/customers/{customer_id}', \App\Action\Customer\CustomerReaderAction::class);
            $app->put('/customers/{customer_id}', \App\Action\Customer\CustomerUpdaterAction::class);
            $app->delete('/customers/{customer_id}', \App\Action\Customer\CustomerDeleterAction::class);

            $app->group(
                '/jurisdiction',
                function (RouteCollectorProxy $app) {
                    $app->get('/list', \App\Action\Jurisdiction\JurisdictionListAction::class);
                    $app->post('/create', \App\Action\Jurisdiction\JurisdictionCreatorAction::class);
                    $app->get('/view/{id}', \App\Action\Jurisdiction\JurisdictionReaderAction::class);
                    $app->post('/update/{id}', \App\Action\Jurisdiction\JurisdictionUpdaterAction::class);
                    $app->post('/delete/{id}', \App\Action\Jurisdiction\JurisdictionDeleterAction::class);
                }
            );

            $app->group(
                '/commune',
                function (RouteCollectorProxy $app) {
                    $app->get('/list', \App\Action\Commune\CommuneListAction::class);
                    $app->post('/create', \App\Action\Commune\CommuneCreatorAction::class);
                    $app->get('/view/{id}', \App\Action\Commune\CommuneReaderAction::class);
                    $app->post('/update/{id}', \App\Action\Commune\CommuneUpdaterAction::class);
                    $app->post('/delete/{id}', \App\Action\Commune\CommuneDeleterAction::class);
                }
            );
        }
    );
};
