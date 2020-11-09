# php-dingtalk-robot
Easy to send dingtalk robot message

## Usage
```shell script
composer require ritaswc/dingtalk-robot
```

## Send Message
```php
$accessToken = '2d1bf0b300...';
$secret = 'SEC7a90caf...';
$isAtAll = false;
$atMobiles = ['130****6666', '188****8888'];
$robot = new \Ritaswc\DingtalkRobot\DingtalkRobot($accessToken, $secret);

$robot->sendText('PHP is the best language in the world!', $isAtAll, $atMobiles);

$robot->sendLink('Charles的小星球',
    '基于wordpress...',
    'https://blog.yinghualuo.cn',
    '');

$robot->sendMarkdown(
    '杭州天气',
    '#### 杭州天气 @150XXXXXXXX \n> 9度，西北风1级，空气良89，相对温度73%\n> ![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png)\n> ###### 10点20分发布 [天气](https://blog.yinghualuo.cn) \n',
    $isAtAll,
    $atMobiles
);

$robot->sendSingleActionCard(
    '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
    '![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png) 
 ### 乔布斯 20 年前想打造的苹果咖啡厅 
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划',
    '阅读全文',
    'https://blog.yinghualuo.cn',
    '0'
);

$robot->sendMultiActionCard(
    '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
    '![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png) 
 ### 乔布斯 20 年前想打造的苹果咖啡厅 
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划',
    '0',
    [[
        'title'     => '内容不错',
        'actionURL' => 'https://blog.yinghualuo.cn'
    ], [
        'title'     => '不感兴趣',
        'actionURL' => 'https://www.dingtalk.com'
    ]]
);

$robot->sendFeedCard([
    [
        'title'      => '时代的火车向前开',
        'messageURL' => 'https://www.dingtalk.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI',
        'picURL'     => 'https://gw.alicdn.com/tfs/TB1ayl9mpYqK1RjSZLeXXbXppXa-170-62.png',
    ], [
        'title'      => '时代的火车向前开2',
        'messageURL' => 'https://www.dingtalk.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI',
        'picURL'     => 'https://gw.alicdn.com/tfs/TB1ayl9mpYqK1RjSZLeXXbXppXa-170-62.png',
    ]
]);
```

## Author Blog
[Charles的小星球](https://blog.yinghualuo.cn)

## Dingtalk Document
[自定义机器人开发](https://ding-doc.dingtalk.com/document#/org-dev-guide/qf2nxq)

## License
MIT