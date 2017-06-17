<?php
// Routes
$app->get('/', 'Bike\Api\Controller\IndexController:indexAction');

$app->group('/oauth2', function () {
    $this->post('/authorize', 'Bike\Api\Controller\OAuth2\IndexController:authorizeAction');
    $this->post('/access_token', 'Bike\Api\Controller\OAuth2\AccessTokenController:indexAction');
});

$app->group('/v1', function () {
    // sms
    $this->get('/sms/send_login_code', 'Bike\Api\Controller\Sms\IndexController:sendLoginCodeAction');
    // user
    $this->any('/users/current', 'Bike\Api\Controller\User\CurrentController');
    // bike
    $this->any('/bikes', 'Bike\Api\Controller\Bike\IndexController');
    $this->any('/bikes/{id}/use', 'Bike\Api\Controller\Bike\UseController');
    $this->any('/bikes/{id}/checkout', 'Bike\Api\Controller\Bike\CheckoutController');
})->add(function ($request, $response, $next) {
    $apiService = $this->get('bike.api.service.api');
    // 验证access_token
    try {
        $server = $this->get('bike.api.service.oauth2')->createResourceServer();
        $request = $server->validateAuthenticatedRequest($request);
    } catch (\Exception $e) {
        $e = new \Bike\Api\Exception\Logic\InvalidAccessTokenException();
        return $response->withJson($apiService->handleError($e));
    }
    // 验证版本
    try {
        $clientId = $request->getAttribute('oauth_client_id');
        $version = $request->getHeader('bike_api_version');
        if (!$version || !$apiService->isVersionExpired($clientId, $version[0])) {
            throw new \Bike\Api\Exception\Logic\UpgradeRequiredException();
        }
    } catch (\Exception $e) {
        return $response->withJson($apiService->handleError($e));
    }
    // next
    return $next($request, $response);
});
