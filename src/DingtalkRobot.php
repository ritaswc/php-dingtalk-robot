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

    /**
     * text类型
     * @param $text
     * @param $isAtAll
     * @param $atMobiles
     * @return array|null
     */
    public function sendText($text, $isAtAll = false, $atMobiles = [])
    {
        return $this->request([
            'msgtype' => 'text',
            'text'    => [
                'content' => (string)$text,
            ],
            'at'      => [
                'isAtAll'   => (bool)$isAtAll,
                'atMobiles' => (array)$atMobiles
            ],
        ]);
    }

    /**
     * Link类型
     * @param $title
     * @param $text
     * @param $messageUrl
     * @param $picUrl
     * @return null|array
     */
    public function sendLink($title, $text, $messageUrl, $picUrl)
    {
        return $this->request([
            'msgtype' => 'link',
            'link'    => [
                'title'      => (string)$title,
                'text'       => (string)$text,
                'messageUrl' => (string)$messageUrl,
                'picUrl'     => (string)$picUrl,
            ],
        ]);
    }

    /**
     * markdown类型
     * @param $title
     * @param $markdownText
     * @param false $isAtAll
     * @param array $atMobiles
     * @return null|array
     */
    public function sendMarkdown($title, $markdownText, $isAtAll = false, $atMobiles = [])
    {
        return $this->request([
            'msgtype'  => 'markdown',
            'markdown' => [
                'title' => (string)$title,
                'text'  => (string)$markdownText,
            ],
            'at'       => [
                'isAtAll'   => (bool)$isAtAll,
                'atMobiles' => (array)$atMobiles,
            ],
        ]);
    }

    /**
     * 整体跳转ActionCard
     * @param $title
     * @param $markdownText
     * @param $singleTitle
     * @param $singleURL
     * @param $btnOrientation 0-按钮竖直排列，1-按钮横向排列
     * @return null|array
     */
    public function sendSingleActionCard($title, $markdownText, $singleTitle, $singleURL, $btnOrientation = '0')
    {
        return $this->request([
            'msgtype'    => 'actionCard',
            'actionCard' => [
                'title'          => (string)$title,
                'text'           => (string)$markdownText,
                'btnOrientation' => (string)$btnOrientation,
                'singleTitle'    => (string)$singleTitle,
                'singleURL'      => (string)$singleURL,
            ],
        ]);
    }

    /**
     * 独立跳转ActionCard
     * @param $title
     * @param $markdownText
     * @param $btnOrientation 0-按钮竖直排列，1-按钮横向排列
     * @param $buttons [['title' => '内容不错', 'actionURL' => 'https://blog.yinghualuo.cn'], ['title' => '不感兴趣', 'actionURL' => 'https://www.dingtalk.com/']]
     * @return null|array
     */
    public function sendMultiActionCard($title, $markdownText, $btnOrientation, $buttons)
    {
        return $this->request([
            'msgtype'    => 'actionCard',
            'actionCard' => [
                'title'          => (string)$title,
                'text'           => (string)$markdownText,
                'btnOrientation' => (string)$btnOrientation,
                'btns'           => (string)$buttons,
            ],
        ]);
    }

    /**
     * FeedCard类型
     * @param $links [['title' => '时代的火车向前开', 'messageURL' => 'https://www.dingtalk.com/', 'picURL' => 'https://gw.alicdn.com/tfs/TB1ayl9mpYqK1RjSZLeXXbXppXa-170-62.png']]
     * @return null|array
     */
    public function sendFeedCard($links)
    {
        return $this->request([
            'msgtype' => 'feedCard',
            'links'   => (array)$links,
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

    /**
     * @param $data
     * @return null|array
     */
    private function request($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=utf-8']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $body = curl_exec($ch);
        curl_close($ch);
        return json_decode($body, true);
    }
}