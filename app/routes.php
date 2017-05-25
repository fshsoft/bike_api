<?php
// Routes
$app->get('/', 'Bike\\Api\\Controller\\IndexController:indexAction');

$app->group('/oauth2', function () {
    $this->get('/authorize', 'Bike\\Api\\Controller\\OAuth2\\IndexController:authorizeAction');
    $this->get('/access_token', 'Bike\\Api\\Controller\\OAuth2\\IndexController:accessTokenAction');
});
