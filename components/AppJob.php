<?php

namespace app\components;

class AppJob
{
    const STATUS_OK = 'ok';
    const STATUS_FAILED = 'failed';
    const STATUS_OK_DELAYED = 'ok_delayed';
    
    public $delayedSeconds = 0;
    
    public function onExecute()
    {
        return self::STATUS_OK;
    }
}