<?php

namespace Matteao\AliyunSms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Matteao\AliyunSms\Exceptions\HttpException;
use Matteao\AliyunSms\Exceptions\InvalidArgumentException;

class AliyunSms
{
    const ALIYUN_REGION_ID = 'cn-hangzhou';

    const ALIYUN_PRODUCT = 'Dysmsapi';

    const ALIYUN_VERSION = '2017-05-25';

    const ALIYUN_ACTION = 'SendSms';

    const ALIYUN_METHOD = 'POST';

    const ALIYUN_HOST = 'dysmsapi.aliyuncs.com';

    /**
     * 
     * 短信签名
     */
    private $signName;

    /**
     * 构造函数
     * 
     */
    public function __construct($accessKeyId, $accessSecret, $signName)
    {
        $this->signName = $signName;
        AlibabaCloud::accessKeyClient($accessKeyId, $accessSecret)
            ->regionId(self::ALIYUN_REGION_ID)
            ->asDefaultClient();
    }

    /**
     * 指定手机号发送短信
     * $phone 手机号
     * $templateCode 模板编号
     * $params 模板参数
     */
    public function sendSms($phone, $templateCode, $params = [])
    {
        //参数有:手机号,模板,
        if (empty($phone) || empty($templateCode) || !is_array($params)) {
            throw new InvalidArgumentException('参数错误');
        }

        $query = array_merge([
            'PhoneNumbers' => $phone,
            'SignName' => $this->signName,
            'TemplateCode' => $templateCode,
            'TemplateParam' => json_encode($params)
        ]);

        //发送短信
        try {
            $result = AlibabaCloud::rpc()
                ->product(self::ALIYUN_PRODUCT)
                ->version(self::ALIYUN_VERSION)
                ->action(self::ALIYUN_ACTION)
                ->method(self::ALIYUN_METHOD)
                ->host(self::ALIYUN_HOST)
                ->options([
                    'query' => $query,
                ])
                ->request();
            return $result->toArray();
        } catch (ClientException $e) {
            throw new HttpException($e->getErrorMessage());
        } catch (ServerException $e) {
            throw new HttpException($e->getErrorMessage());
        }
    }
}
