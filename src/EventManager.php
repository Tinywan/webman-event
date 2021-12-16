<?php
/**
 * @desc 监听事件
 * @author Tinywan(ShaoBo Wan)
 * @date 2021/12/16 15:13
 */

declare(strict_types=1);

namespace webman\event;

use support\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\Event;
use Webman\Bootstrap;

/**
 * @see EventDispatcher
 * @mxin EventDispatcher
 * @method static dispatch(object $event, string $eventName = null) 执行事件调度
 * @method static getListeners(string $eventName = null) 
 * @method static getListenerPriority(string $eventName, $listener)
 * @method static hasListeners(string $eventName = null) 是否存在事件监听
 */
class EventManager implements Bootstrap
{
    /**
     * 事件派派遣器实例
     * @var EventDispatcher
     */
    protected static $instance = null;

    /**
     * @desc: 进程启动时调用
     * @param \Workerman\Worker $worker
     * @return mixed|void
     * @author Tinywan(ShaoBo Wan)
     */
    public static function start($worker)
    {
        if ($worker) {
            if (is_null(static::$instance)) {
                static::$instance = Container::get(EventDispatcher::class);
                $listeners = config('event.listener');
                if ($listeners) {
                    foreach ($listeners as $eventName => $listener) {
                        $instance = new $listener;
                        if (method_exists($instance,'handle')) {
                            static::$instance->addListener($eventName, function (Event $event, $eventName, $dispatcher){
                                if (false === $event->handle($dispatcher)) {
                                    $event->stopPropagation();
                                }
                            });
                        }
                    }
                }

               $subscribers = config('event.subscriber');
               if ($subscribers) {
                   foreach ($subscribers as $subscriber) {
                       static::$instance->addSubscriber(Container::get($subscriber));
                   }
               }
            }
        }
    }

    /**
     * 触发事件
     * @param Event $event
     * @param null $params
     */
    public static function trigger(Event $event, $params = null)
    {
        $listeners = config('event.listener');
        $eventList = array_unique($listeners,SORT_REGULAR);
        if ($eventList) {
            foreach ($eventList as $eventName => $_instance) {
                if ($event instanceof $_instance) {
                    static::$instance->dispatch(new $_instance(), $eventName);
                }
            }
        }
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