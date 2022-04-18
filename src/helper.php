<?php

use Symfony\Contracts\EventDispatcher\Event;

if (!function_exists('event')) {

    /**
     * @desc: event 助手函数
     * @param Event $event
     * @param string $eventName
     * @return mixed
     * @author Tinywan(ShaoBo Wan)
     */
    function event(Event $event, string $eventName)
    {
        return \support\Container::get(Symfony\Component\EventDispatcher\EventDispatcher::class)->dispatch($event,$eventName);
    }
}