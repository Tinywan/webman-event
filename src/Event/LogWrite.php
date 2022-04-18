<?php
/**
 * @desc LogWrite.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2022/4/18 16:38
 */
declare(strict_types=1);


namespace Tinywan\Event;


class LogWrite
{
    /** @var array */
    public $log;

    public function __construct($log)
    {
        $this->log     = $log;
    }
}