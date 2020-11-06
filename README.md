# php-dingtalk-robot
Easy to send dingtalk robot message

## Usage
```shell script
composer require ritaswc/dingtalk-robot
```

```php
$accessToken = '2d1bf0b300...';
$secret = 'SEC7a90caf...';
$robot = new \Ritaswc\DingtalkRobot\DingtalkRobot($accessToken, $secret);
$robot->sendText('PHP is the best language!');
```

## Author Blog
[Charles的小星球](https://blog.yinghualuo.cn)

## Dingtalk Document
[自定义机器人开发](https://ding-doc.dingtalk.com/document#/org-dev-guide/qf2nxq)

## License
MIT