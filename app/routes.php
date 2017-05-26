<?php
// Routes
$app->get('/', 'Bike\\Api\\Controller\\IndexController:indexAction');

$app->group('/oauth2', function () {
    $this->post('/authorize', 'Bike\\Api\\Controller\\OAuth2\\IndexController:authorizeAction');
    $this->post('/access_token', 'Bike\\Api\\Controller\\OAuth2\\IndexController:accessTokenAction');
});

$app->group('/v1', function () {
    $this->get('/user/test', 'Bike\\Api\\Controller\\User\\IndexController:testAction');
})->add(function ($request, $response, $next) {
    try {
        $accessTokenRepository = new \Bike\Api\OAuth2\Repository\AccessTokenRepository($this);
        $publicKeyPath = $this->get('settings')['oauth2']['public_key'];
        $server = new \League\OAuth2\Server\ResourceServer(
            $accessTokenRepository,
            $publicKeyPath
        );
        $request = $server->validateAuthenticatedRequest($request);
        return $next($request, $response);
    } catch (\Exception $e) {
        $exception = new \Bike\Api\Exception\Logic\InvalidAccessTokenException();
        return $response->withJson(array(
            'errno' => $exception->getCode(),
            'errmsg' => $exception->getMessage(),
        ));
    }
});
