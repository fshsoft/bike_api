<?php

namespace Bike\Api\Service;

use Interop\Container\ContainerInterface;

use Bike\Api\Util\ArgUtil;

class AlipayService extends AbstractService
{
    protected $gatewayUrl;

    protected $appId;

    protected $privateKey;

    protected $publicKey;

    protected $alipayPublicKey;

    protected $format = 'json';

    protected $charset = 'UTF-8';

    protected $signType = 'RSA2';

    public function __construct(ContainerInterface, $container)
    {
        parent::__construct($container);
        $settings = $this->container->get('settings')['alipay'];
        $this->gatewayUrl = $settings['gateway'];
        $this->appId = $settings['app_id'];
        $this->privateKey = $this->parseKeyFile($settings['private_key']);
        $this->publicKey = $this->parseKeyFile($settings['public_key']);
        $this->alipayPublicKey = $this->parseKeyFile($settings['alipay_public_key']);
    }

    public function createOrder(array $args)
    {
        $args = ArgUtil::getArgs($args, [
            'user_id',
            'amount',
        ]);
        $settings = $this->container->get('settings')['alipay'];
        $aop = new \AopClient;
        $aop->gatewayUrl = $settings['gateway'];
        $aop->appId = $settings['app_id'];
        $aop->rsaPrivateKey = $this->privateKey;
        $aop->format = $this->format;
        $aop->charset = $this->charset;
        $aop->signType = $this->signType;
        $aop->alipayrsaPublicKey = $this->alipayPublicKey;
        $request = new \AlipayTradeAppPayRequest();
        $bizcontent = "{\"body\":\"我是测试数据\","
            . "\"subject\": \"App支付测试\","
            . "\"out_trade_no\": \"20170125test01\","
            . "\"timeout_express\": \"30m\","
            . "\"total_amount\": \"0.01\","
            . "\"product_code\":\"QUICK_MSECURITY_PAY\""
            . "}";
        $request->setNotifyUrl("商户外网可以访问的异步地址");
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        echo htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
    }

    protected function parseKeyFile($keyFile)
    {
        $s = file_get_contents($keyFile);
        return preg_replace([
            0 => '/\-+.+\-+/',
            1 => '/\s+/'
        ], [
            0 => '',
            1 => '',
        ], $s);
    }
}
