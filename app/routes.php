<?php
// Routes
$app->get('/', 'Bike\\Api\\Controller\\IndexController:indexAction');

$app->get('/oauth2/authorize', 'Bike\\Api\\Controller\\OAuth2\\IndexController:authorizeAction');
$app->get('/oauth2/access_token', 'Bike\\Api\\Controller\\OAuth2\\IndexController:accessTokenAction');

