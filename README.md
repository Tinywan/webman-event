# webman-event

[![license](https://img.shields.io/github/license/Tinywan/webman-event)]()
[![996.icu](https://img.shields.io/badge/link-996.icu-red.svg)](https://996.icu)
[![Build status](https://github.com/Tinywan/dnmp/workflows/CI/badge.svg)]()
[![webman-event](https://img.shields.io/github/v/release/tinywan/webman-event?include_prereleases)]()
[![webman-event](https://img.shields.io/badge/build-passing-brightgreen.svg)]()
[![webman-event](https://img.shields.io/github/last-commit/tinywan/webman-event/main)]()
[![webman-event](https://img.shields.io/github/v/tag/tinywan/webman-event?color=ff69b4)]()

事件相比较中间件的优势是事件比中间件更加精准定位（或者说粒度更细），并且更适合一些业务场景的扩展。例如，我们通常会遇到用户注册或者登录后需要做一系列操作，通过事件系统可以做到不侵入原有代码完成登录的操作扩展，降低系统的耦合性的同时，也降低了BUG的可能性。

## Requirements

- [symfony/event-dispatcher](https://github.com/symfony/event-dispatcher)

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

### 监听事件

事件类 `LogErrorEvent.php`

```php
namespace extend\event;


use Symfony\Contracts\EventDispatcher\Event;

class LogErrorEvent extends Event
{
    const NAME = 'log.error';  // 事件名，事件的唯一标识

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        return 'Error：错误日志处理, '.$this->message."\n";
    }
}
```

监听配置
```php
return [
    // 事件监听
    'listener'    => [
        \extend\event\LogErrorEvent::NAME  => \extend\event\LogErrorEvent::class,
    ],
];
```

### 事件订阅

待完善

### 事件触发器

触发 `LogErrorEvent` 事件。

```php
EventManager::trigger(new LogErrorEvent('【事件】错误日志'),LogErrorEvent::NAME);
```
## License

This project is licensed under the [Apache 2.0 license](LICENSE).
