# webman-event

[![license](https://img.shields.io/github/license/Tinywan/webman-event)]()
[![996.icu](https://img.shields.io/badge/link-996.icu-red.svg)](https://996.icu)
[![Build status](https://github.com/Tinywan/dnmp/workflows/CI/badge.svg)]()
[![webman-event](https://img.shields.io/github/v/release/tinywan/webman-event?include_prereleases)]()
[![webman-event](https://img.shields.io/badge/build-passing-brightgreen.svg)]()
[![webman-event](https://img.shields.io/packagist/php-v/tinywan/webman-event)]()
[![webman-event](https://img.shields.io/github/last-commit/tinywan/webman-event/main)]()
[![webman-event](https://img.shields.io/github/v/tag/tinywan/webman-event?color=ff69b4)]()

## Requirements

- PHP > 7.2
- symfony/event-dispatcher

## 安装

```shell script
composer require tinywan/webman-event
```
## 配置 

事件配置文件 `config/event.php` 内容如下

```php
return [
    // 事件监听
    'listener'    => [],

    // 事件订阅器
    'subscriber' => [],
];
```
### 进程启动配置

打开 `config/bootstrap.php`，加入如下配置：

```php
return [
    // 这里省略了其它配置 ...
    webman\event\EventManager::class,
];
```
## 快速开始

### 事件监听

监听类 `LoggerListener.php`

```php
namespace extend\event\listener;

use Symfony\Contracts\EventDispatcher\Event;

class LoggerListener extends Event
{
    const NAME = 'sys:logger';

    public function handle($event)
    {
        // 事件监听处理
        var_dump('LoggerListener 事件监听处理');
    }
}
```

监听配置
```php
return [
    // 事件监听
    'listener'    => [
        \extend\event\listener\LoggerListener::NAME  => \extend\event\listener\LoggerListener::class,
    ],
];
```
### 事件订阅

待完善
### 触发器
```php
EventManager::trigger(new LoggerListener());
```
## License

This project is licensed under the [Apache 2.0 license](LICENSE).
