<?php

namespace Bike\Api\Service;

use Bike\Api\Exception\Logic\LogicException;
use Bike\Api\Db\Primary\SmsCode;

class SmsService extends AbstractService
{
    public function sendLoginCode($mobile)
    {
        // 手机未注册，则注册
        $userService = $this->container->get('bike.api.service.user');
        $user = $userService->getUserByMobile($mobile);
        if ($user) {
            $userId = $user->getId();
        } else {
            $userId = $userService->createUser(array(
                'mobile' => $mobile,
            ));
        }

        $config = $this->container->get('settings')['aliyun']['sms']['login'];
        $aliyunService = $this->container->get('bike.api.service.aliyun');   
        $client = $aliyunService->getClient($config['region']);
        $request = new Sms\SingleSendSmsRequest();
        $request->setSignName($config['sign']);
        $request->setTemplateCode($config['template']);
        $request->setRecNum(strval($mobile));

        /*模板变量，数字一定要转换为字符串*/
        $code = $this->genCode();
        $params = array(
            'code' => $code,
            'product' => $this->container->get('settings')['site_name'],
        );
        $request->setParamString(json_encode($params));

        $time = time();
        $smsCodeDao = $this->container->get('bike.api.dao.primary.sms_code');
        $smsCodeConn = $smsCodeDao->getConn();
        $smsCodeConn->beginTransaction();
        $smsCode = new SmsCode();
        $smsCode
            ->setUserId($userId)
            ->setCode($code)
            ->setMobile($mobile)
            ->setType(SmsCode::TYPE_LOGIN)
            ->setStatus(SmsCode::STATUS_NOT_USED)
            ->setExpirationTime($time + $config['ttl'])
            ->setCreateTime($time);
        try {
            $smsCodeDao->create($smsCode);
            $response = $client->getAcsResponse($request);
            $smsCodeConn->commit();
            return $code;
        } catch (\Exception  $e) {
            $smsCodeConn->rollBack();
            throw new LogicException('手机验证码发送失败');
        }
    }

    protected function genCode()
    {
        return strval(mt_rand(100000, 999999));
    }
}
