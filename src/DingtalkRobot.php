<?php

namespace Ritaswc\DingtalkRobot;

class DingtalkRobot
{
    private $accessToken;
    private $secret;
    private $timestamp;

    public function __construct($accessToken, $secret)
    {
        $this->accessToken = $accessToken;
        $this->secret = $secret;
    }

    const URL = 'https://oapi.dingtalk.com/robot/send?access_token=';

    public function sendText($text, $isAtAll = false, $atMobiles = [])
    {
        $this->request([
            'msgtype' => 'text',
            'text'    => [
                'content' => $text,
            ],
            'at'      => [
                'atMobiles' => $atMobiles,
                'isAtAll'   => $isAtAll,
            ]
        ]);
    }

    public function sign()
    {
        list($s1, $s2) = explode(' ', microtime());
        $this->timestamp = (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
        $data = $this->timestamp . "\n" . $this->secret;
        $signStr = base64_encode(hash_hmac('sha256', $data, $this->secret, true));
        return utf8_encode(urlencode($signStr));
    }

    private function url()
    {
        $sign = $this->sign();
        return static::URL . $this->accessToken . '&timestamp=' . $this->timestamp . '&sign=' . $sign;
    }

    private function request($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=utf-8']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}