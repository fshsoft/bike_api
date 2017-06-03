<?php

namespace Bike\Api\Service;

use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;

use Bike\Api\Exception\Logic\LogicException;

class SmsService extends AbstractService
{
    const TYPE_LOGIN = 1;

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

        $settings = $this->container->get('settings')['aliyun'];
        $accessKeyId = $settings['access_key_id'];
        $accessKeySecret = $settings['access_key_secret'];

        $config = $this->container->get('settings')['aliyun']['sms']['login'];

        $time = time();
        $code = $this->genCode();

        $key = array(
            'mobile' => $mobile,
            'type' => self::TYPE_LOGIN,
        );
        $value = array(
            'mobile' => $mobile,
            'type' => self::TYPE_LOGIN,
            'code' => $code,
            'user_id' => $userId,
            'expire_time' => $time + $config['ttl'],
            'create_time' => $time,
        );

        $smsCodeRedisDao = $this->container->get('bike.api.redis.dao.sms_code');
        $smsCodeRedisDao->save($key, $value);

        // 发送短信
        $client = new Client($config['endpoint'], $accessKeyId, $accessKeySecret);
        $topic = $client->getTopicRef($config['topic']);
        $batchSmsAttributes = new BatchSmsAttributes($config['sign'], $config['template']);
        $batchSmsAttributes->addReceiver($mobile, array(
            'code' => $code,
            'product' => $this->container->get('settings')['site_name'],
        ));
        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));
        $messageBody = "smsmessage";
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        $res = $topic->publishMessage($request);

        return $code;
    }

    public function verifyLoginCode($mobile, $code)
    {
        $smsCodeDao = $this->container->get('bike.api.dao.primary.sms_code');
        $smsCode = $smsCodeDao->find(array(
            'mobile' => $mobile,
            'type' => self::TYPE_LOGIN,
        ));
        if ($smsCode && $smsCode['code'] == $code) {
            return true;
        }
        return false;
    }

    protected function genCode()
    {
        return strval(mt_rand(100000, 999999));
    }
}
