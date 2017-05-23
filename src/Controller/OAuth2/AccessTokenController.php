<?php

namespace Bike\Api\Controller\OAuth2;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

use Bike\Api\Controller\AbstractController;

class AccessTokenController extends AbstractController
{
    /**
     * @Route("/oauth2/access_token", name="access_token")
     */
    public function indexAction(Request $request)
    {
        return $this->jsonSuccess();
    }
}
