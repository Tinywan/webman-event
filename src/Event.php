<?php
/**
 * @desc 监听事件
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/12/16 15:13
 */
declare(strict_types=1);

namespace Tinywan;

use support\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\Event as SymfonyEvent;
use Webman\Bootstrap;
use Workerman\Worker;

/**
 * @see EventDispatcher
 * @mxin EventDispatcher
 * @method static dispatch(object $event, string $eventName = null) 执行事件调度
 * @method static getListeners(string $eventName = null) 
 * @method static getListenerPriority(string $eventName, $listener)
 * @method static hasListeners(string $eventName = null) 是否存在事件监听
 */
class Event implements Bootstrap
{
    /**
     * 事件派派遣器实例
     * @var EventDispatcher
     */
    protected static $instance = null;

    /**
     * @desc: 进程启动时调用
     * @param Worker $worker
     * @return void
     */
    public static function start($worker)
    {
        if ($worker) {
            if (is_null(static::$instance)) {
                static::$instance = Container::get(EventDispatcher::class);
                $config = config('plugin.tinywan.event.app.event');
                if (isset($config['listener']) && !empty($config['listener'])) {
                    foreach ($config['listener'] as $eventName => $listener) {
                        if (false === static::$instance->hasListeners($eventName)) {
                            static::$instance->addListener($eventName, function (SymfonyEvent $event, $eventName, $dispatcher){
                                // trigger 触发事件 do somthing
                                if (false === $event->handle()) {
                                    $event->stopPropagation();
                                }
                            });
                        }
                    }
                }

                if (isset($config['subscriber']) && !empty($config['subscriber'])) {
                    foreach ($config['subscriber'] as $subscriber) {
                        static::$instance->addSubscriber(Container::get($subscriber));
                    }
                }
            }
        }
    }

    /**
     * 触发事件
     * @param Event $event
     * @param string|null $eventName
     */
    public static function trigger(Event $event, string $eventName = null)
    {
        static::$instance->dispatch($event,$eventName);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @author Tinywan(ShaoBo Wan)
     */
    public static function __callStatic($name, $arguments)
    {
        return static::$instance->{$name}(...$arguments);
    }
}